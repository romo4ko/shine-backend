<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Predictions\Prediction;
use Modules\Properties\Property;

class PredictionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBasePredictions();
    }

    public function createBasePredictions(): void
    {
        $predictionsConfig = config('predictions');
        $property = new Property();

        DB::transaction(function () use ($predictionsConfig, $property) {
            foreach ($predictionsConfig as $type => $predictions) {
                foreach ($predictions as $prediction) {
                    Prediction::create(
                        [
                            'text' => $prediction,
                            'type_id' => $property->getId('prediction_types', $type),
                        ],
                    );
                }
            }
        });
    }
}
