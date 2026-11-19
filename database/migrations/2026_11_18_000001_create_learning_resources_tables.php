<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resource_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('learning_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('resource_category_id')->nullable()->constrained('resource_categories')->nullOnDelete();
            $table->string('topic')->nullable();                 // optional topic / unit
            $table->string('file_path');                         // private disk
            $table->string('original_name');
            $table->string('mime_type', 150);
            $table->unsignedBigInteger('size');
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('download_count')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->index('title');
        });

        Schema::create('learning_resource_level', function (Blueprint $table) {
            $table->foreignId('learning_resource_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->primary(['learning_resource_id', 'level_id']);
        });

        Schema::create('learning_resource_subject', function (Blueprint $table) {
            $table->foreignId('learning_resource_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->primary(['learning_resource_id', 'subject_id']);
        });

        Schema::create('learning_resource_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_resource_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('downloaded_at')->useCurrent();
            $table->index(['teacher_id', 'downloaded_at']);
        });
    }

    public function down(): void
    {
        foreach (['learning_resource_downloads', 'learning_resource_subject', 'learning_resource_level', 'learning_resources', 'resource_categories'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
