<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserImage;

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
        $users = User::factory(User::class)->count(10)->create();
        $images = ['/images/stubs/man.jpg', '/images/stubs/woman.jpg'];

        $property = new Property();

        foreach ($users as $user) {
            UserImage::create([
                'user_id' => $user->id,
                'sorting' => 1,
                'path' => $images[array_rand($images)],
            ]);

            $birtdate = Carbon::parse(fake()->date());

            $user->properties->update([
                'name' => fake()->firstName(),
                'text' => fake()->realText(),
                'birthdate' => $birtdate,
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

            $sign = null;
            foreach (config('properties.zodiac') as $zodiac) {

                $dateFrom = Carbon::createFromFormat('d.m', $zodiac['dates'][0]);
                $dateTo = Carbon::createFromFormat('d.m', $zodiac['dates'][1]);

                if ($birtdate->month == $dateFrom->month && $birtdate->day >= $dateFrom->day ||
                    $birtdate->month == $dateTo->month && $birtdate->day <= $dateTo->day
                ) {
                    $sign = $property->getId('zodiac', $zodiac['code']);
                }
            }

            $user->properties->update(['sign' => $sign]);
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
