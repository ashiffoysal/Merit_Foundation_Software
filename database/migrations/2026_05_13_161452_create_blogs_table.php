<?php

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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            // Blog basic info
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');

            // Image
            $table->string('featured_image')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Status
            $table->enum('status', ['draft', 'published'])->default('draft');

            // Optional category & author
            $table->unsignedBigInteger('category_id')->nullable();
            // Published date
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            // Foreign keys (optional)
            $table->foreign('category_id')->references('id')->on('blogs_categories')->onDelete('set null');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
