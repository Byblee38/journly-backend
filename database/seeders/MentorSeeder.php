<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        Mentor::create([
            'name' => 'Ilham Fadilah',
            'identity_number' => '',
        ]);
    }
}
