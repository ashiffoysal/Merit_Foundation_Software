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
            // Personal
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('photo_path')->nullable();
            // Academic
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->foreignId('school_id')->nullable()->constrained('schools')->nullOnDelete();
            $table->foreignId('year_group_id')->nullable()->constrained('year_groups')->nullOnDelete();
            // Financial
            $table->decimal('registration_fee', 8, 2)->default(0);
            $table->decimal('refundable_deposit', 8, 2)->default(50);
            $table->decimal('hourly_fee', 8, 2)->default(0);
            // Assessment
            $table->date('assessment_date')->nullable();
            $table->time('assessment_time')->nullable();
            $table->foreignId('student_status_id')->nullable()->constrained('student_statuses')->nullOnDelete();
            // Additional
            $table->text('note')->nullable();
            $table->boolean('childcare')->default(false);
            $table->boolean('is_fee_delayed')->default(false)->index();
            $table->date('due_date_extended')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });

        Schema::create('student_parent', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->primary(['student_id', 'parent_id']);
        });

        Schema::create('student_branches', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->primary(['student_id', 'branch_id']);
        });

        Schema::create('student_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('event', 40);             // registered, status_changed, branches_changed ...
            $table->string('description');
            $table->json('changes')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['student_histories', 'student_branches', 'student_parent', 'students'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
