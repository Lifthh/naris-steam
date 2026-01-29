<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Steam Biasa
            [
                'name' => 'Steam Biasa - Motor Kecil',
                'description' => 'Cuci steam untuk motor kecil (bebek, matic kecil)',
                'vehicle_type' => 'kecil',
                'category' => 'steam',
                'price' => 13000,
                'estimated_time' => 15,
            ],
            [
                'name' => 'Steam Biasa - Motor Sedang',
                'description' => 'Cuci steam untuk motor sedang (matic besar, sport kecil)',
                'vehicle_type' => 'sedang',
                'category' => 'steam',
                'price' => 15000,
                'estimated_time' => 20,
            ],
            [
                'name' => 'Steam Biasa - Motor Besar',
                'description' => 'Cuci steam untuk motor besar (sport, moge)',
                'vehicle_type' => 'besar',
                'category' => 'steam',
                'price' => 17000,
                'estimated_time' => 25,
            ],
            // Premium Wash
            [
                'name' => 'Premium Wash - Motor Kecil',
                'description' => 'Cuci premium dengan wax dan poles untuk motor kecil',
                'vehicle_type' => 'kecil',
                'category' => 'premium',
                'price' => 30000,
                'estimated_time' => 30,
            ],
            [
                'name' => 'Premium Wash - Motor Sedang',
                'description' => 'Cuci premium dengan wax dan poles untuk motor sedang',
                'vehicle_type' => 'sedang',
                'category' => 'premium',
                'price' => 35000,
                'estimated_time' => 40,
            ],
            [
                'name' => 'Premium Wash - Motor Besar',
                'description' => 'Cuci premium dengan wax dan poles untuk motor besar',
                'vehicle_type' => 'besar',
                'category' => 'premium',
                'price' => 40000,
                'estimated_time' => 50,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}