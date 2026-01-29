<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            [
                'name' => 'Semir Ban',
                'description' => 'Semir ban hitam mengkilap',
                'price' => 5000,
            ],
            [
                'name' => 'Parfum Motor',
                'description' => 'Pewangi motor tahan lama',
                'price' => 3000,
            ],
            [
                'name' => 'Poles Body',
                'description' => 'Poles body motor mengkilap',
                'price' => 10000,
            ],
            [
                'name' => 'Cuci Helm',
                'description' => 'Cuci helm bagian dalam dan luar',
                'price' => 8000,
            ],
        ];

        foreach ($addons as $addon) {
            Addon::create($addon);
        }
    }
}