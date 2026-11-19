<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            // Personal
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 30);
            $table->string('email')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('postcode', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('photo_path')->nullable();          // private disk
            // Account
            $table->string('password');
            $table->rememberToken();
            // Employment
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('job_title')->nullable();
            $table->string('ni_number', 20)->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_phone', 30)->nullable();
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->date('joining_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->boolean('has_dbs')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });

        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->primary(['teacher_id', 'subject_id']);
        });

        Schema::create('level_teacher', function (Blueprint $table) {
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->primary(['teacher_id', 'level_id']);
        });

        Schema::create('teacher_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30)->index();     // proof_of_address, proof_of_id, dbs, contract, other
            $table->string('title')->nullable();
            $table->string('path');                  // private disk
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->foreignId('uploaded_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('teacher_employment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('event', 40);             // joined, branch_changed, rate_changed, resigned ...
            $table->string('description');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->date('effective_date')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['teacher_employment_histories', 'teacher_documents', 'level_teacher', 'subject_teacher', 'teachers'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
