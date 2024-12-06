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
            'user_id' => User::factory(),
            'identifier_code' => $this->faker->unique()->lexify('CLASS-?????'),
            'class_name' => $this->faker->word,
            'description' => $this->faker->text,
            'background_image' => 'class-bg-default.jpg',
            'background_color' => $this->faker->hexColor,
            'text_color' => $this->faker->hexColor,
            'is_archived' => false,
        ];
    }
}