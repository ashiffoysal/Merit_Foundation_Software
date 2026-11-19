<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });

        // One row per class that actually took place (or was cancelled) on a date.
        Schema::create('lesson_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->date('session_date');
            $table->time('starts_at');                 // snapshot of the schedule on that day
            $table->time('ends_at');
            $table->enum('status', ['held', 'cancelled'])->default('held');
            $table->string('topic')->nullable();       // what was taught
            $table->text('notes')->nullable();         // class notes
            $table->text('homework')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['lesson_id', 'session_date']);
            $table->index(['teacher_id', 'session_date']);
        });

        // Attendance + progress for each student in that class.
        Schema::create('lesson_session_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->enum('attendance', ['present', 'late', 'absent', 'excused'])->default('present');
            $table->enum('progress', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->nullable();
            $table->unsignedTinyInteger('score')->nullable();   // 1–10
            $table->boolean('homework_done')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['lesson_session_id', 'student_id']);
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_session_students');
        Schema::dropIfExists('lesson_sessions');
        Schema::table('teachers', fn (Blueprint $t) => $t->dropColumn('last_login_at'));
    }
};
