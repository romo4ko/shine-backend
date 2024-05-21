<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cities\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createBaseCities();
    }

    public function createBaseCities(): void
    {
        $cities = config("cities");

        DB::transaction(function () use ($cities) {
            foreach ($cities as $city) {
                City::updateOrCreate(
                    [
                        'name' => $city['name'],
                        'region' => $city['region'],
                        'district' => $city['district'],
                        'lon' => $city['lon'],
                        'lat' => $city['lat'],
                    ]
                );
            }
        });
    }
}
