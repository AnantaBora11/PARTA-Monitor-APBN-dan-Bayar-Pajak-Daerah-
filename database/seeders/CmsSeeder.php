<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default About Us
        Setting::create([
            'key' => 'about_us',
            'value' => 'We are dedicated to providing the best government services to our citizens. Our platform is designed to be user-friendly, secure, and efficient. We believe in transparency and accountability. (From Seeder)',
        ]);

        // Default Cards
        Card::create([
            'title' => 'E-KTP Renewal',
            'description' => 'Renew your E-KTP online without hassle.',
            'image' => 'https://via.placeholder.com/400x200?text=E-KTP', 
        ]);

        Card::create([
            'title' => 'Tax Amnesty',
            'description' => 'Learn more about the new tax amnesty program.',
            'image' => 'https://via.placeholder.com/400x200?text=Tax',
        ]);

        Card::create([
            'title' => 'Public Transport',
            'description' => 'New routes available for the city bus network.',
            'image' => 'https://via.placeholder.com/400x200?text=Transport',
        ]);
    }
}
