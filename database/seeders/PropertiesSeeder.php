<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Properties\Models\Property;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBaseProperties();
    }

    public function createBaseProperties(): void
    {
        $propertiesConfig = config('properties');

        DB::transaction(function () use ($propertiesConfig) {
            foreach ($propertiesConfig as $type => $properties) {
                foreach ($properties as $property) {
                    Property::updateOrCreate(
                        [
                            'type' => $type,
                            'code' => $property['code'],
                        ],
                        [
                            'value' => $property['value'],
                        ]
                    );
                }
            }
        });
    }
}
