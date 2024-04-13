<?php

namespace Database\Seeders;

use App\Models\ServicePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define package durations and base prices
        $packages = [
            ['duration' => '1 month', 'base_price' => 120],
            ['duration' => '2 months', 'base_price' => 220],
            ['duration' => '3 months', 'base_price' => 300],
            ['duration' => '4 months', 'base_price' => 400],
            ['duration' => '5 months', 'base_price' => 500],
            ['duration' => '6 months', 'base_price' => 600]
        ];

        // Seed subscription packages
        foreach ($packages as $package) {

            $months = (int)$package['duration'][0];

            $price = $package['base_price'] * $months;

            ServicePrice::create([
                'duration' => $package['duration'],
                'price' => $price,

            ]);
        }
    }
}
