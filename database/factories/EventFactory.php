<?php

namespace Database\Factories;

use App\Models\Society;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $end = (clone $start)->modify('+2 hours');

        return [
            'society_id' => Society::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'start_time' => $start,
            'end_time' => $end,
        ];
    }

    public function society(Society $society): static
    {
        return $this->state(fn (array $attributes) => [
            'society_id' => $society->id,
        ]);
    }
}
