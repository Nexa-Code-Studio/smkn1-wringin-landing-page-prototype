<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'angkatan',
    'lulusan',
])]
class GraduationSetting extends Model
{
}
