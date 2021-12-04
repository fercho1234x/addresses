<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $states = State::factory(10)->create();
        $id = State::all()->random()->id;
        return [
            'code' => $this->faker->postcode,
            'settlement' => $this->faker->word,
            'settlement_type' => $this->faker->word,
            'municipality' => $this->faker->word,
            'city' => $this->faker->city,
            'zone' => $this->faker->word,
            'state_id' => $id
        ];
    }
}
