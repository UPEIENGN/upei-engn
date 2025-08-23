<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Society>
 */
class SocietyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraphs(3, true),
            'email' => $this->faker->unique()->companyEmail(),

            'facebook_url' => $this->faker->optional()->url(),
            'instagram_handle' => $this->faker->optional()->userName(),
            'twitter_handle' => $this->faker->optional()->userName(),
            'discord_url' => $this->faker->optional()->url(),

            'meeting_schedule' => $this->faker->dayOfWeek().' at '.$this->faker->time(),
            'meeting_location' => $this->faker->buildingNumber().' '.$this->faker->streetName(),
        ];
    }
}
