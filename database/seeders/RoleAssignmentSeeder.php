<?php

namespace Database\Seeders;

use App\Enums\RoleEnums;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $key => $user){
            if($key == 0) $user->assignRole(RoleEnums::TEACHER);
            if($key > 0) $user->assignRole(RoleEnums::STUDENT);
        }
    }
}
