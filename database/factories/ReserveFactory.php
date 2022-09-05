<?php

namespace Database\Factories;
use App\Models\Reserve;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserve>
 */
class ReserveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(1),
            'menu_id' => $this->faker->randomElement([1,2,3,4]),
            'start_date' =>$this->faker->date(),
            'end_date' => $this->faker->date(),
            'reserve_type' => 1,
        ];

        // 'user_id' => function () {
        //     return factory(\App\User::class)->create()->id;
        // },
    }
}
