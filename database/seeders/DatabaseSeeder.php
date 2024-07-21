<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::query()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.ru',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            PropertiesSeeder::class,
            CitiesSeeder::class,
            PredictionsSeeder::class,
            DocumentSeeder::class,
        ]);

        if (env('APP_DEBUG')) {
            $this->call([
                TestDatabaseSeeder::class,
            ]);
        }
    }
}
