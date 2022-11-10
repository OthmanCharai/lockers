<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Locker;
use App\Models\User;

class LockerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Locker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'level' => $this->faker->word,
            'location' => $this->faker->word,
            'locker_number' => $this->faker->word,
            'status' => $this->faker->randomElement(["pending","successful","failed"]),

        ];
    }
}
