<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Material;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MaterialControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        // Create materials dengan classroom_id
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        Material::factory()->create(['classroom_id' => $classroom->id]);
        Material::factory()->create(['classroom_id' => $classroom->id]);

        $response = $this->getJson(route('materials.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                '*' => [
                    'id',
                    'topic_id',
                    'classroom_id',
                    'title',
                    'content',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        // Create material
        $classroom = Classroom::factory()->create(); // Membuat classroom
        $material = Material::factory()->create(['classroom_id' => $classroom->id]);

        $response = $this->getJson(route('materials.show', ['material' => $material->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'topic_id',
                'classroom_id',
                'title',
                'content',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_store_valid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        $classroom = Classroom::factory()->create(); // Membuat classroom
        $topic = Topic::factory()->create(); // Membuat topic

        $data = [
            'topic_id' => $topic->id,
            'classroom_id' => $classroom->id,
            'title' => 'Material 101',
            'content' => 'Introduction to Materials',
        ];

        $response = $this->postJson(route('materials.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'topic_id',
                'classroom_id',
                'title',
                'content',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_store_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        $classroom = Classroom::factory()->create(); // Membuat classroom
        $topic = Topic::factory()->create(); // Membuat topic

        // Mengirim data yang tidak valid (misalnya title kosong)
        $data = [
            'topic_id' => $topic->id,
            'classroom_id' => $classroom->id,
            'title' => '', // Invalid: title kosong
            'content' => 'Content for invalid material',
        ];

        $response = $this->postJson(route('materials.store'), $data);

        $response->assertStatus(422); // Expecting validation error (422 Unprocessable Entity)
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data',
        ]);
        $response->assertJsonFragment([
            'message' => 'Validation failed.',
        ]);
    }


    public function test_update_valid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        // Create material
        $classroom = Classroom::factory()->create();
        $material = Material::factory()->create(['classroom_id' => $classroom->id]);

        $topic = Topic::factory()->create(); // Membuat topic baru

        $data = [
            'topic_id' => $topic->id,
            'classroom_id' => $classroom->id,
            'title' => 'Updated Material Title',
            'content' => 'Updated Material Content',
        ];

        $response = $this->putJson(route('materials.update', ['material' => $material->id]), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'topic_id',
                'classroom_id',
                'title',
                'content',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_update_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        // Create material
        $classroom = Classroom::factory()->create();
        $material = Material::factory()->create(['classroom_id' => $classroom->id]);

        // Create new topic for update
        $topic = Topic::factory()->create(); // Membuat topic baru

        // Mengirim data update yang tidak valid (misalnya title kosong)
        $data = [
            'topic_id' => $topic->id,
            'classroom_id' => $classroom->id,
            'title' => '', // Invalid: title kosong
            'content' => 'Updated content with invalid title',
        ];

        $response = $this->putJson(route('materials.update', ['material' => $material->id]), $data);

        $response->assertStatus(422); // Expecting validation error (422 Unprocessable Entity)
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data',
        ]);
        $response->assertJsonFragment([
            'message' => 'Validation failed.',
        ]);
    }


    public function test_destroy_valid_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Semua pengguna bisa mengakses endpoint ini

        // Create material
        $classroom = Classroom::factory()->create();
        $material = Material::factory()->create(['classroom_id' => $classroom->id]);

        $response = $this->deleteJson(route('materials.destroy', ['material' => $material->id]));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Material deleted successfully.',
        ]);

        // Verifikasi material sudah terhapus
        $this->assertDatabaseMissing('materials', ['id' => $material->id]);
    }
}
