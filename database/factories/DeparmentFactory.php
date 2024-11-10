<?php

namespace Database\Factories;

use App\Models\Deparment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deparment>
 */
class DeparmentFactory extends Factory
{
    protected $model = Deparment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company()
        ];
    }
}
