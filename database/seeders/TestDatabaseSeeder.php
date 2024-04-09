<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Images\Models\UserImage;
use Modules\Users\Models\User;
use Modules\Users\Properties\Models\UserProperties;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createBaseUsers();
    }

    public function createBaseUsers(): void
    {
        $users = User::factory(User::class)->count(10)->create();
        $images = ["/storage/images/stubs/man.jpg", "/storage/images/stubs/woman.jpg"];

        foreach ($users as $user) {
            UserImage::create([
                'user_id' => $user->id,
                'path' => $images[array_rand($images)],
            ]);

            UserProperties::create([
                'user_id' => $user->id,
                'text' => fake()->realText(),
                'birthdate' => fake()->date(),
                'sex' => $this->getRandomProperty('gender'),
                'city' => $this->getRandomCity(),
                'purpose' => $this->getRandomProperty('purpose'),
                'fs' => $this->getRandomProperty('fs'),
                'children' => $this->getRandomProperty('children'),
                'smoking' => $this->getRandomProperty('smoking'),
                'alcohol' => $this->getRandomProperty('alcohol'),
                'education' => $this->getRandomProperty('education'),
                'sign' => $this->getRandomProperty('zodiac'),
                'height' => rand(150, 200),
                'tags' => null
            ]);
        }
    }

    public function getRandomProperty(string $property): ?int
    {
        $property = Property::where('type', $property)->inRandomOrder()->first();
        if ($property) {
            return $property->id;
        }
        return null;
    }

    public function getRandomCity(): ?int
    {
        $city = City::inRandomOrder()->first();
        if ($city) {
            return $city->id;
        }
        return null;
    }
}
