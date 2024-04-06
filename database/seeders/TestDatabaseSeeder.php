<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cities\Models\City;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;
use Modules\Users\Models\UserProperties;
use Modules\Users\Models\UserSettings;

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
		$users = User::factory()->count(10)->make();
        
		foreach ($users as $user) {
			UserSettings::create([
				'user_id' => $user->id,
				'text' => fake('ru')->text,
				'birthdate' => fake()->date('d-m-Y'),
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

		foreach ($users as $user) {
			UserProperties::create([
				'user_id' => $user->id,
				'text' => fake('ru')->text,
				'birthdate' => fake()->date('d-m-Y'),
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

	function getRandomProperty(string $property): ?Property
	{
		return Property::where('type', $property)->inRandomOrder()->first()->id;
	}

	function getRandomCity(): ?City
	{
		return City::inRandomOrder()->first()->id;
	}
}
