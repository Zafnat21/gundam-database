<?php

namespace Database\Seeders;

use App\Models\MobileSuit;
use Illuminate\Database\Seeder;

class MobileSuitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MobileSuit::create([
            'name' => 'RX-78-2 Gundam',
            'image_url' => 'https://static.wikia.nocookie.net/gundam/images/9/9f/RX-78-2_Gundam_-_Front.png',
            'description' => 'Mobile Suit ikonik milik Amuro Ray dari seri Mobile Suit Gundam.',
            'tags' => 'UC, Federation',
        ]);

        MobileSuit::create([
            'name' => 'RX-93 Nu Gundam',
            'image_url' => 'https://static.wikia.nocookie.net/gundam/images/8/8e/RX-93_Nu_Gundam_-_Front.png',
            'description' => 'Mobile Suit canggih milik Amuro Ray dalam Char’s Counterattack.',
            'tags' => 'UC, Federation, Newtype',
        ]);

        MobileSuit::create([
            'name' => 'MSN-04 Sazabi',
            'image_url' => 'https://static.wikia.nocookie.net/gundam/images/3/36/MSN-04_Sazabi_-_Front.png',
            'description' => 'Mobile Suit merah milik Char Aznable dalam Char’s Counterattack.',
            'tags' => 'UC, Neo Zeon, Commander',
        ]);
    }
}