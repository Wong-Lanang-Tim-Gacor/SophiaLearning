<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResourceAttachment>
 */
class ResourceAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resource_id' => Resource::factory(),
            'file_name' => $this->faker->word . '.pdf',
            'file_path' => 'storage/files/' . $this->faker->unique()->word . '.pdf',
            'file_type' => 'application/pdf',
            'file_size' => $this->faker->numberBetween(500, 10000),
            'file_extension' => 'pdf',
            'file_mime' => 'application/pdf',
            'file_url' => 'https://example.com/files/' . $this->faker->unique()->word . '.pdf',
        ];
    }
}
