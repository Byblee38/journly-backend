<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Administrator::create([
            'name' => 'Admin Kurikulum',
            'nip' => '198503122010011002',
        ]);
    }
}
