<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'username',
    'password',
    'nama',
    'nisn',
    'kelas',
    'tempat_lahir',
    'tanggal_lahir',
    'status_kelulusan',
    'pas_foto'
])]
#[Hidden(['password', 'remember_token'])]
class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    public function photoUrl(): ?string
    {
        if (!$this->pas_foto) {
            return null;
        }

        $path = ltrim($this->pas_foto, '/');

        if (str_starts_with($path, 'images/siswa/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
        ];
    }
}
