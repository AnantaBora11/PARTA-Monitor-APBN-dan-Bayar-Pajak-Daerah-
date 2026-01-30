<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com', 
            'nik' => '0000000000000000',
            'phone' => '0000000000',
            'date_of_birth' => '1990-01-01',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);
    }
}
