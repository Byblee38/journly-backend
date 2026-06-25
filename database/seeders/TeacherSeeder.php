<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'name' => 'Siti Rahmawati, S.Pd.',
            'nip' => '198811242014022003',
        ]);
    }
}
