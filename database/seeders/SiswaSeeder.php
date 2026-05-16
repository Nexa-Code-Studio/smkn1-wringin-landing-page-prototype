<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::updateOrCreate(
            ['nisn' => '1234567890'],
            [
                'username' => 'aulia.rahma',
                'password' => Hash::make('123'),
                'nama' => 'Aulia Rahma',
                'kelas' => 'XI RPL 2',
                'can_submit_news' => true,
            ]
        );
    }
}
