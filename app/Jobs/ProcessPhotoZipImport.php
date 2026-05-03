<?php

namespace App\Jobs;

use App\Models\ImportJob;
use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use ZipArchive;

class ProcessPhotoZipImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(private readonly int $importJobId)
    {
        $this->onQueue('imports');
    }

    public function handle(): void
    {
        $importJob = ImportJob::findOrFail($this->importJobId);

        if (!in_array($importJob->status, ['queued', 'failed'], true)) {
            return;
        }

        $importJob->update([
            'status' => 'processing',
            'started_at' => now(),
            'finished_at' => null,
            'error_summary' => null,
        ]);

        $zipPath = Storage::disk('local')->path($importJob->zip_path);
        $zip = new ZipArchive();
        $zipOpened = false;

        try {
            if (!is_file($zipPath) || $zip->open($zipPath) !== true) {
                throw new \RuntimeException('File ZIP tidak dapat dibuka.');
            }

            $zipOpened = true;

            $totalFiles = $this->countImageEntries($zip);
            $importJob->update(['total_files' => $totalFiles]);

            Storage::disk('public')->makeDirectory('siswa/alternative');
            Storage::disk('public')->makeDirectory('siswa/webp');

            $processed = 0;
            $success = 0;
            $failed = 0;
            $errors = [];

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);

                if (!$this->isProcessableImageEntry($filename)) {
                    continue;
                }

                $processed++;
                $fileinfo = pathinfo($filename);
                $extension = strtolower($fileinfo['extension'] ?? '');
                $nisn = trim($fileinfo['filename'] ?? '');

                if (!preg_match('/^[0-9]{10}$/', $nisn)) {
                    $failed++;
                    $this->recordError($errors, $filename, 'Nama file harus berupa NISN 10 digit.');
                    $this->updateProgress($importJob, $processed, $success, $failed, $errors);
                    continue;
                }

                $siswa = Siswa::where('nisn', $nisn)->first();
                if (!$siswa) {
                    $failed++;
                    $this->recordError($errors, $filename, 'Siswa dengan NISN tersebut tidak ditemukan.');
                    $this->updateProgress($importJob, $processed, $success, $failed, $errors);
                    continue;
                }

                $originalContent = $zip->getFromIndex($i);
                if ($originalContent === false || $originalContent === '') {
                    $failed++;
                    $this->recordError($errors, $filename, 'File gambar gagal dibaca dari ZIP.');
                    $this->updateProgress($importJob, $processed, $success, $failed, $errors);
                    continue;
                }

                $altFilename = $nisn . '.' . $extension;
                $altStoragePath = 'siswa/alternative/' . $altFilename;
                Storage::disk('public')->put($altStoragePath, $originalContent);

                $processedToWebp = false;
                if (function_exists('imagecreatefromstring')) {
                    try {
                        $image = imagecreatefromstring($originalContent);
                        if ($image !== false) {
                            $webpFilename = $nisn . '.webp';
                            $webpStoragePath = 'siswa/webp/' . $webpFilename;
                            imagewebp($image, Storage::disk('public')->path($webpStoragePath), 80);
                            imagedestroy($image);

                            $siswa->update(['pas_foto' => $webpStoragePath]);
                            $processedToWebp = true;
                        }
                    } catch (Throwable $e) {
                        Log::warning('Gagal konversi foto siswa ke WebP.', [
                            'import_job_id' => $importJob->id,
                            'nisn' => $nisn,
                            'message' => $e->getMessage(),
                        ]);
                    }
                }

                if (!$processedToWebp) {
                    $siswa->update(['pas_foto' => $altStoragePath]);
                }

                $success++;
                $this->updateProgress($importJob, $processed, $success, $failed, $errors);
            }

            $zip->close();
            $zipOpened = false;

            $importJob->update([
                'status' => 'completed',
                'processed_files' => $processed,
                'success_count' => $success,
                'failed_count' => $failed,
                'error_summary' => $errors ?: null,
                'finished_at' => now(),
            ]);

            Storage::disk('local')->delete($importJob->zip_path);
        } catch (Throwable $e) {
            if ($zipOpened) {
                $zip->close();
            }

            $importJob->update([
                'status' => 'failed',
                'error_summary' => [[
                    'file' => null,
                    'message' => 'Import gagal: ' . $e->getMessage(),
                ]],
                'finished_at' => now(),
            ]);

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        $importJob = ImportJob::find($this->importJobId);

        if (!$importJob) {
            return;
        }

        $importJob->update([
            'status' => 'failed',
            'error_summary' => [[
                'file' => null,
                'message' => 'Import gagal: ' . $exception->getMessage(),
            ]],
            'finished_at' => now(),
        ]);
    }

    private function countImageEntries(ZipArchive $zip): int
    {
        $total = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            if ($this->isProcessableImageEntry($zip->getNameIndex($i))) {
                $total++;
            }
        }

        return $total;
    }

    private function isProcessableImageEntry(?string $filename): bool
    {
        if (!$filename || str_ends_with($filename, '/') || str_contains($filename, '__MACOSX')) {
            return false;
        }

        $basename = basename($filename);
        if ($basename === '' || str_starts_with($basename, '.')) {
            return false;
        }

        $extension = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true);
    }

    private function updateProgress(ImportJob $importJob, int $processed, int $success, int $failed, array $errors): void
    {
        $importJob->update([
            'processed_files' => $processed,
            'success_count' => $success,
            'failed_count' => $failed,
            'error_summary' => $errors ?: null,
        ]);
    }

    private function recordError(array &$errors, string $filename, string $message): void
    {
        if (count($errors) >= 100) {
            return;
        }

        $errors[] = [
            'file' => basename($filename),
            'message' => $message,
        ];
    }
}
