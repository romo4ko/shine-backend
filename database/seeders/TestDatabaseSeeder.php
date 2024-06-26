<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserImage;
use Modules\Users\Zodiac;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBaseUsers();
    }

    public function createBaseUsers(): void
    {
        $zodiac = new Zodiac();
        $users = User::factory(User::class)->count(10)->create();
        $images = ['/images/stubs/man.jpg', '/images/stubs/woman.jpg'];

        foreach ($users as $user) {
            UserImage::create([
                'user_id' => $user->id,
                'sorting' => 1,
                'path' => $images[array_rand($images)],
            ]);

            $birthdate = Carbon::parse(
                fake()->dateTimeBetween(
                    Carbon::now()->subYears(50),
                    Carbon::now()->subYears(18)
                )
            );

            $user->properties->update([
                'name' => fake()->firstName(),
                'text' => fake()->realText(),
                'birthdate' => $birthdate,
                'gender' => $this->getRandomProperty('gender'),
                'city' => $this->getRandomCity(),
                'purpose' => $this->getRandomProperty('purpose'),
                'fs' => $this->getRandomProperty('fs'),
                'children' => $this->getRandomProperty('children'),
                'smoking' => $this->getRandomProperty('smoking'),
                'alcohol' => $this->getRandomProperty('alcohol'),
                'education' => $this->getRandomProperty('education'),
                'height' => rand(150, 200),
                'tags' => null,
            ]);

            $sign = $zodiac->getSignByDate($birthdate);

            $user->properties->update(['sign' => $sign->id]);
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
