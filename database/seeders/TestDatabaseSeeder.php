<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Properties\Models\Property;
use Modules\Users\Models\User;

class PropertiesSeeder extends Seeder
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
		


        
    }
}
