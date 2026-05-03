<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'uuid',
    'admin_user_id',
    'type',
    'original_filename',
    'zip_path',
    'status',
    'total_files',
    'processed_files',
    'success_count',
    'failed_count',
    'error_summary',
    'started_at',
    'finished_at',
])]
class ImportJob extends Model
{
    protected function casts(): array
    {
        return [
            'error_summary' => 'array',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
