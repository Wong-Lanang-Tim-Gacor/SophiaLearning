<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Topic;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TopicControllerTest extends TestCase
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

        // Create classrooms and topics
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        Topic::factory()->create(['classroom_id' => $classroom->id]);
        Topic::factory()->create(['classroom_id' => $classroom->id]);

        // Melakukan request ke endpoint index
        $response = $this->getJson(route('topics.index'));

        // Memastikan response status adalah 200 dan data topik ada
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                '*' => [
                    'id',
                    'classroom_id',
                    'topic_name',
                    'created_at',
                    'updated_at',
                    'classroom' => ['id', 'class_name'],
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

        // Create a classroom and topic
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        $topic = Topic::factory()->create(['classroom_id' => $classroom->id]);

        // Melakukan request ke endpoint show dengan ID
        $response = $this->getJson(route('topics.show', ['topic' => $topic->id]));

        // Memastikan response status adalah 200 dan data topik ada
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'classroom_id',
                'topic_name',
                'created_at',
                'updated_at',
                'classroom' => ['id', 'class_name'],
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

        // Create a classroom
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);

        // Data untuk topik yang valid
        $data = [
            'classroom_id' => $classroom->id,
            'topic_name' => 'Physics Basics',
        ];

        $response = $this->postJson(route('topics.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'classroom_id',
                'topic_name',
                'created_at',
                'updated_at',
                'classroom' => ['id', 'class_name'],
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

        // Data untuk topik yang tidak valid (classroom_id tidak ada)
        $data = [
            'classroom_id' => 9999, // ID kelas yang tidak ada
            'topic_name' => '',     // Nama topik kosong
        ];

        $response = $this->postJson(route('topics.store'), $data);

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

        // Create a classroom and topic
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        $topic = Topic::factory()->create(['classroom_id' => $classroom->id]);

        // Data update yang valid
        $data = [
            'classroom_id' => $classroom->id,
            'topic_name' => 'Advanced Physics',
        ];

        $response = $this->putJson(route('topics.update', ['topic' => $topic->id]), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                'id',
                'classroom_id',
                'topic_name',
                'created_at',
                'updated_at',
                'classroom' => ['id', 'class_name'],
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

        // Create a classroom and topic
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        $topic = Topic::factory()->create(['classroom_id' => $classroom->id]);

        // Data update yang tidak valid
        $data = [
            'classroom_id' => 9999, // ID kelas yang tidak ada
            'topic_name' => '',     // Nama topik kosong
        ];

        $response = $this->putJson(route('topics.update', ['topic' => $topic->id]), $data);

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
     * Test untuk endpoint destroy
     * 
     * @return void
     */
    public function test_destroy_valid_id()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Create a classroom and topic
        $classroom = Classroom::factory()->create(['user_id' => $user->id]);
        $topic = Topic::factory()->create(['classroom_id' => $classroom->id]);

        // Melakukan request ke endpoint destroy dengan ID topic
        $response = $this->deleteJson(route('topics.destroy', ['topic' => $topic->id]));

        // Memastikan status response adalah 200 dan data sudah terhapus
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Topic deleted successfully.',
        ]);

        // Memastikan topic tidak ada lagi di database
        $this->assertDatabaseMissing('topics', ['id' => $topic->id]);
    }
}
