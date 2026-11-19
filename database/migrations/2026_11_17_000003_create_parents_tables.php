<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 30)->index();
            $table->string('email')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('emergency_phone', 30)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('relationship', 30)->nullable(); // mother, father, guardian ...
            $table->string('profession')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });

        Schema::create('parent_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->string('type', 30)->index();
            $table->string('title')->nullable();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->foreignId('uploaded_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_documents');
        Schema::dropIfExists('parents');
    }
};
