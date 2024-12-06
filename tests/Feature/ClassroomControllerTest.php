<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClassroomControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test untuk endpoint index
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create classrooms
        Classroom::factory()->create(['user_id' => $user->id]);
        Classroom::factory()->create(['user_id' => $user->id]);

        // Melakukan request ke endpoint index
        $response = $this->getJson(route('classrooms.index'));

        // Memastikan response status adalah 200 dan data kelas ada
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'identifier_code',
                    'class_name',
                    'description',
                    'background_image',
                    'background_color',
                    'text_color',
                    'is_archived',
                    'created_at',
                    'updated_at',
                    'teacher' => ['id', 'name'],
                    'students_count',
                ],
            ],
        ]);
    }

    /**
     * Test untuk endpoint show
     *
     * @return void
     */
    public function test_show()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create classroom
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);

        // Melakukan request ke endpoint show dengan ID
        $response = $this->getJson(route('classrooms.show', ['classroom' => $classroom->id]));

        // Memastikan response status adalah 200 dan data kelas ada
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'user_id',
                'identifier_code',
                'class_name',
                'description',
                'background_image',
                'background_color',
                'text_color',
                'is_archived',
                'created_at',
                'updated_at',
                'teacher' => ['id', 'name'],
                'students_count',
            ],
        ]);
    }

    /**
     * Test untuk endpoint store
     * dengan data yang valid
     * @return void
     */
    public function test_store_valid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        $data = [
            'user_id' => $user->id,
            'identifier_code' => 'ABC123',
            'class_name' => 'Mathematics 101',
            'description' => 'Introduction to Mathematics',
            'background_image' => 'background.jpg',
            'background_color' => '#ffffff',
            'text_color' => '#000000',
            'is_archived' => false,
        ];

        $response = $this->postJson(route('classrooms.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'user_id',
                'identifier_code',
                'class_name',
                'description',
                'background_image',
                'background_color',
                'text_color',
                'is_archived',
                'created_at',
                'updated_at',
                'teacher' => ['id', 'name'],
            ],
        ]);
    }

    /**
     * Test untuk endpoint store
     * dengan data yang tidak valid
     * @return void
     */
    public function test_store_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        $data = [
            'user_id' => $user->id,
            'identifier_code' => '',  // Invalid data: identifier_code kosong
            'class_name' => '',       // Invalid data: class_name kosong
            'description' => 'Invalid Classroom',
            'background_image' => 'background.jpg',
            'background_color' => '#ffffff',
            'text_color' => '#000000',
            'is_archived' => false,
        ];

        $response = $this->postJson(route('classrooms.store'), $data);

        $response->assertStatus(422); // Expect validation error
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data',
        ]);
        $response->assertJsonFragment([
            'message' => 'Validation failed.',
        ]);
    }

    /**
     * Test untuk endpoint update
     * dengan data yang valid
     * @return void
     */
    public function test_update_valid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create a classroom
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);

        // Data update yang valid
        $data = [
            'user_id' => $user->id,
            'identifier_code' => 'DEF456',
            'class_name' => 'Physics 101',
            'description' => 'Introduction to Physics',
            'background_image' => 'background_new.jpg',
            'background_color' => '#000000',
            'text_color' => '#ffffff',
            'is_archived' => false,
        ];

        $response = $this->putJson(route('classrooms.update', ['classroom' => $classroom->id]), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'user_id',
                'identifier_code',
                'class_name',
                'description',
                'background_image',
                'background_color',
                'text_color',
                'is_archived',
                'created_at',
                'updated_at',
                'teacher' => ['id', 'name'],
                'students_count',
            ],
        ]);
    }

    /**
     * Test untuk endpoint update
     * dengan data yang tidak valid
     * @return void
     */
    public function test_update_invalid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create a classroom
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);

        // Data update yang tidak valid
        $data = [
            'user_id' => $user->id,
            'identifier_code' => '', // Invalid: Kosong
            'class_name' => '',      // Invalid: Kosong
            'description' => 'Invalid Update',
            'background_image' => 'background_invalid.jpg',
            'background_color' => '#000000',
            'text_color' => '#ffffff',
            'is_archived' => false,
        ];

        $response = $this->putJson(route('classrooms.update', ['classroom' => $classroom->id]), $data);

        $response->assertStatus(422); // Expect validation error
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data',
        ]);
        $response->assertJsonFragment([
            'message' => 'Validation failed.',
        ]);
    }

    /**
     * Test untuk endpoint destory
     * 
     * @return void
     */
    public function test_destroy_valid_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create a classroom
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);

        // Melakukan request ke endpoint destroy dengan ID classroom
        $response = $this->deleteJson(route('classrooms.destroy', ['classroom' => $classroom->id]));

        // Memastikan status response adalah 200 dan data sudah terhapus
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Classroom deleted successfully.',
        ]);

        // Memastikan classroom tidak ada lagi di database
        $this->assertDatabaseMissing('classrooms', ['id' => $classroom->id]);
    }
}
