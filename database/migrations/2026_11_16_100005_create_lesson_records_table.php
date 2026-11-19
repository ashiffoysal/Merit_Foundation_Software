<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One row = one class session: which student, which teacher,
     * which lesson + topic was covered, and how it went.
     */
    public function up(): void
    {
        Schema::create('lesson_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->foreignId('lesson_topic_id')->nullable()->constrained('lesson_topics')->nullOnDelete();

            $table->date('lesson_date');
            $table->enum('status', ['completed', 'in_progress', 'needs_revision', 'absent'])->default('completed');
            $table->unsignedTinyInteger('score')->nullable(); // 1–10
            $table->text('teacher_comment')->nullable();
            $table->text('homework')->nullable();

            $table->timestamps();

            $table->index(['student_id', 'lesson_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_records');
    }
};
