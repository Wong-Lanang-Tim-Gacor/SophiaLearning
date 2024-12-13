<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Resource;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'email' => "user@example.com",
            'password' => Hash::make('password'),
            'username' => "user_test",
            'name' => "User for test",
            'phone' => "0812345678",
        ]);
        User::factory(5)->create();
        Classroom::factory(2)->create();
        Resource::factory(5)->assignment()->create();
        Resource::factory(5)->material()->create();
        Resource::factory(5)->announcement()->create();
        $this->call([
            RoleSeeder::class,
            RoleAssignmentSeeder::class
        ]);
    }
}
