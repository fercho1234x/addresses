<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\State;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        State::factory(100)->create();
        Address::factory(100)->create();
    }
}
