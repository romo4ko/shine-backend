<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Premium\Models\Price;

class PricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPrices();
    }

    public function createPrices(): void
    {
        $prices = config('prices');

        foreach ($prices as $price) {
            Price::query()->create($price);
        }
    }
}
