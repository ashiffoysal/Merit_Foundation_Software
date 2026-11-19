<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->restrictOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
            // Schedule
            $table->unsignedTinyInteger('weekday');          // 0 = Saturday ... 6 = Friday
            $table->time('start_time');
            $table->unsignedSmallInteger('duration_minutes');
            $table->time('end_time');                         // derived, stored for fast conflict checks
            $table->unsignedSmallInteger('capacity')->default(1);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            // Configuration
            $table->enum('gender', ['boys', 'girls', 'mixed'])->default('mixed');
            $table->decimal('teacher_hourly_rate', 8, 2)->default(0);
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_one_to_one')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['teacher_id', 'weekday', 'start_time']);
            $table->index(['classroom_id', 'weekday', 'start_time']);
        });

        Schema::create('lesson_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('enrolled_at')->nullable();
            $table->timestamps();
            $table->unique(['lesson_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_students');
        Schema::dropIfExists('lessons');
    }
};
