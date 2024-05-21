<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Prediction\Models\Prediction;

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
        $predictionsConfig = config("predictions");

        DB::transaction(function () use ($predictionsConfig) {
            foreach ($predictionsConfig as $predictions) {
                foreach ($predictions as $prediction) {
                    Prediction::updateOrCreate(
                        [
                            'text' => $prediction['text'],
                            'gender' => $prediction['gender'],
                            'sign' => $prediction['sign'],
                            'type' => $prediction['type'],
                        ],
                    );
                }
            }
        });
    }
}
