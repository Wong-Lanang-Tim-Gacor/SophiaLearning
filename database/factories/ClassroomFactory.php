<?php

namespace Database\Factories;

use App\Enums\ClassroomStatusEnums;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classRoomsStatus = ClassroomStatusEnums::toArray();
        return [
            'identifier_code' => $this->faker->unique()->word,
            'user_id' => User::inRandomOrder()->first()->id,
            'class_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'status' => $classRoomsStatus[array_rand($classRoomsStatus)],
        ];
    }
}