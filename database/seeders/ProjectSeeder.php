<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $types = ['Infrastruktur', 'Pendidikan', 'Kesehatan', 'Teknologi', 'Pariwisata', 'Lingkungan'];

        for ($i = 0; $i < 50; $i++) {
            // Generate a random date within the last 10 months to simulate monthly progress
            $date = $faker->dateTimeBetween('-10 months', 'now');
            
            Project::create([
                'title' => 'Pembangunan ' . $faker->words(3, true),
                'description' => $faker->paragraph(3),
                'budget' => $faker->numberBetween(100000000, 5000000000), // 100jt - 5M
                'progress' => $faker->numberBetween(0, 100),
                'type' => $faker->randomElement($types),
                'image' => null, 
                'latitude' => $faker->latitude(-7.85, -7.70), // Approximate Yogyakarta range
                'longitude' => $faker->longitude(110.30, 110.45),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
