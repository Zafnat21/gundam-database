<?php

namespace Database\Seeders;

use App\Models\Pilot;
use App\Models\MobileSuit;
use Illuminate\Database\Seeder;

class PilotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amuro = Pilot::create([
            'name' => 'Amuro Ray',
            'image_url' => 'https://static.wikia.nocookie.net/gundam/images/0/0e/Amuro_Ray_UC_0093.png',
            'description' => 'Pilot utama Gundam dan salah satu Newtype paling terkenal di Universal Century.',
            'tags' => 'UC, Federation, Newtype',
        ]);

        $char = Pilot::create([
            'name' => 'Char Aznable',
            'image_url' => 'https://static.wikia.nocookie.net/gundam/images/6/69/Char_Aznable_UC_0093.png',
            'description' => 'Rival utama Amuro Ray dan pemimpin Neo Zeon dalam Char’s Counterattack.',
            'tags' => 'UC, Neo Zeon, Commander',
        ]);

        $rx78 = MobileSuit::where('name', 'RX-78-2 Gundam')->first();
        $nu = MobileSuit::where('name', 'RX-93 Nu Gundam')->first();
        $sazabi = MobileSuit::where('name', 'MSN-04 Sazabi')->first();

        $amuro->mobileSuits()->attach([$rx78->id, $nu->id]);
        $char->mobileSuits()->attach([$sazabi->id]);
    }
}