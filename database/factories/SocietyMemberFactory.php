<?php

namespace Database\Factories;

use App\Models\Society;
use App\SocietyMemberRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocietyMember>
 */
class SocietyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'society_id' => Society::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'role' => $this->faker->randomElement(SocietyMemberRole::cases()),
            'title' => $this->faker->optional()->jobTitle(),
            'description' => $this->faker->optional()->paragraph(),
            'renewed_at' => $this->faker->optional()->date(),
        ];
    }

    public function society(Society $society): static
    {
        return $this->state(fn (array $attributes) => [
            'society_id' => $society->id,
        ]);
    }
}
