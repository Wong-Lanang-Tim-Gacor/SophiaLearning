<?php

namespace Database\Factories;

use App\Enums\ResourceTypeEnum;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classroom_id' => Classroom::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'type' => $this->faker->randomElement(ResourceTypeEnum::toArray()),
        ];
    }

    public function assignment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ResourceTypeEnum::ASSIGNMENT
        ]);
    }

    public function material(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ResourceTypeEnum::MATERIAL
        ]);
    }

    public function announcement(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ResourceTypeEnum::ANNOUNCEMENT
        ]);
    }
}
