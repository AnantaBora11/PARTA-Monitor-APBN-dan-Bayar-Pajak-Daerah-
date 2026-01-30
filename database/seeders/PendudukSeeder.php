<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Existing manual data
        Penduduk::firstOrCreate(
            ['nik' => '1234567890123456'],
            [
                'nama' => 'Ananta Bora Masariku',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2001-01-01',
                'jenis_kelamin' => 'L',
            ]
        );
        
        Penduduk::firstOrCreate(
            ['nik' => '9876543210987654'],
            [
                'nama' => 'Adik Kecil',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2010-01-01',
                'jenis_kelamin' => 'P',
            ]
        );
        
        Penduduk::firstOrCreate(
            ['nik' => '0000000000000000'],
            [
                'nama' => 'Administrator',
                'tempat_lahir' => 'System',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
            ]
        );

        // Generate 50 random residents
        for ($i = 0; $i < 50; $i++) {
            Penduduk::create([
                'nik' => $faker->unique()->numerify('################'),
                'nama' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            ]);
        }
    }
}
