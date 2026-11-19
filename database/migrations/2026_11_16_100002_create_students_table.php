<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Links (all optional)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();          // parent's login account
            $table->foreignId('book_lesson_id')->nullable()->constrained('book_lessons')->nullOnDelete(); // came from a booking
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();    // assigned teacher

            // Student info
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('current_level')->nullable(); // Complete Beginner, Qaida, Reading Quran, Tajweed, Hifz

            // Parent / guardian
            $table->string('parent_name')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_phone')->nullable();

            $table->date('enrolled_at')->nullable();
            $table->enum('status', ['active', 'paused', 'left'])->default('active');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
