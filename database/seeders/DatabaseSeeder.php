<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create(
            [
                'email' => 'admin@admin.ru',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            PropertiesSeeder::class,
            CitiesSeeder::class,
        ]);

        if (env('APP_DEBUG')) {
            $this->call([
                TestDatabaseSeeder::class,
            ]);
        }
    }
}
