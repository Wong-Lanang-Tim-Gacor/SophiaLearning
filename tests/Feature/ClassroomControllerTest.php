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


    /**
     * Test untuk endpoint joinClass
     *
     * @return void
     */
    public function test_user_can_join_class()
    {
        // Buat user dan login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Buat classroom untuk diuji
        $classroom = Classroom::factory()->create();

        // Request untuk bergabung ke kelas
        $response = $this->postJson("/api/classrooms/{$classroom->id}/join");

        // Verifikasi status dan pesan
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message']
        ]);

        // Verifikasi bahwa siswa telah bergabung dengan kelas
        $this->assertDatabaseHas('student_has_classes', [
            'classroom_id' => $classroom->id,
            'student_id' => $user->id
        ]);
    }

    /**
     * Test untuk endpoint joinClass
     * dengan user yang sudah bergabung mencoba bergabung lagi
     * @return void
     */
    public function test_user_cannot_join_class_already_joined()
    {
        // Buat user dan login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Buat classroom untuk diuji
        $classroom = Classroom::factory()->create();

        // Tambahkan user ke classroom secara manual agar sudah bergabung
        $classroom->students()->attach($user->id);

        // Coba request untuk bergabung lagi ke kelas yang sama
        $response = $this->postJson("/api/classrooms/{$classroom->id}/join");

        // Verifikasi status dan pesan error
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'meta' => ['status', 'message']
        ]);
    }

    /**
     * Test untuk endpoint joinClass
     * di kelas yang tidak valid
     * @return void
     */
    public function test_user_cannot_join_non_existing_class()
    {
        // Buat user dan login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        // Request untuk bergabung dengan kelas yang tidak ada
        $response = $this->postJson("/api/classrooms/999/join");

        // Verifikasi status dan pesan error
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'meta' => ['status', 'message']
        ]);
    }

    /**
     * Test untuk endpoint leaveClass
     *
     * @return void
     */
    public function test_student_can_leave_class()
    {
        // Buat user dan login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        $classroom = Classroom::factory()->create();

        // Menambahkan siswa ke dalam kelas
        $classroom->students()->attach($user->id);

        // Melakukan request untuk keluar dari kelas
        $response = $this->postJson("/api/classrooms/{$classroom->id}/leave");

        // Verifikasi bahwa siswa sudah keluar dan response yang dikembalikan adalah sukses
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message']
        ]);

        // Memastikan bahwa siswa telah dihapus dari tabel pivot
        $this->assertDatabaseMissing('student_has_classes', [
            'classroom_id' => $classroom->id,
            'student_id' => $user->id,
        ]);
    }

    /**
     * Test untuk endpoint getJoinClasses
     *
     * @return void
     */
    public function test_student_can_get_joined_classes()
    {
        // Buat user dan login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']); // Authenticated as user

        $classroom1 = Classroom::factory()->create();
        $classroom2 = Classroom::factory()->create();

        // Menambahkan siswa ke dalam kelas
        $classroom1->students()->attach($user->id);
        $classroom2->students()->attach($user->id);

        // Melakukan request untuk mendapatkan kelas yang diikuti oleh siswa
        $response = $this->getJson('/api/classrooms/student/joined');

        // Verifikasi response dan status yang dikembalikan
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message']
        ]);

        // Memastikan bahwa kedua kelas muncul dalam response
        $response->assertJsonFragment([
            'class_name' => $classroom1->class_name,
        ]);
        $response->assertJsonFragment([
            'class_name' => $classroom2->class_name,
        ]);
    }

    /**
     * Test untuk endpoint getCreatedClasses
     *
     * @return void
     */
    public function test_teacher_can_get_created_classes()
    {
        // Buat user (guru) dan login
        $teacher = User::factory()->create();
        Sanctum::actingAs($teacher, ['*']); // Authenticated as teacher

        // Membuat beberapa kelas
        $classroom1 = Classroom::factory()->create(['user_id' => $teacher->id]);
        $classroom2 = Classroom::factory()->create(['user_id' => $teacher->id]);

        // Melakukan request untuk mendapatkan kelas yang dibuat oleh guru
        $response = $this->getJson('/api/classrooms/teacher/created');

        // Verifikasi response dan status yang dikembalikan
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => ['status', 'message'],
            'data' => [
                '*' => [
                    'id',
                    'identifier_code',
                    'class_name',
                    'description',
                    'background_image',
                    'background_color',
                    'text_color',
                    'is_archived',
                    'students_count',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);

        // Memastikan bahwa kedua kelas muncul dalam response
        $response->assertJsonFragment([
            'class_name' => $classroom1->class_name,
        ]);
        $response->assertJsonFragment([
            'class_name' => $classroom2->class_name,
        ]);
    }
}
