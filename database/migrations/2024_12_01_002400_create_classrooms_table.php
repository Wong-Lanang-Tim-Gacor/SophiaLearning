<?php

use App\Enums\ClassroomStatusEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('identifier_code')->unique();
            $table->string('class_name');
            $table->text('description')->nullable();
            $table->string('background_image')->default('class-bg-default.jpg');
//            $table->string('background_color')->nullable()->default('#FFFFFF');
//            $table->string('text_color')->nullable()->default('#000000');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
