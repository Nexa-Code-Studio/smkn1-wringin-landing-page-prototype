<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'angkatan',
    'lulusan',
    'tanggal_pengumuman',
    'jam_pengumuman',
])]
class GraduationSetting extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal_pengumuman' => 'date',
        ];
    }
}
