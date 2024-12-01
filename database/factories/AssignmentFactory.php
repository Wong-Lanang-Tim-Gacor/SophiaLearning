<?php

namespace Database\Factories;

use App\Enums\AssignmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic_id' => \App\Models\Topic::inRandomOrder()->first()->id,
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'max_score' => $this->faker->numberBetween(10, 100),
            'status' => $this->faker->randomElement(AssignmentStatusEnum::toArray()),
        ];
    }
}