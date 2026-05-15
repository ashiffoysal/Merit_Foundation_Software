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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
             // Page URLs
            $table->string('old_url')->nullable();
            $table->string('new_url')->nullable();

            // SEO Meta
            $table->string('page_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Canonical & Indexing
            $table->string('canonical_url')->nullable();
            $table->enum('index_status', ['index', 'noindex'])
                  ->default('index');

            // Heading Tags
            $table->string('h1_tag')->nullable();

            // Redirect
            $table->enum('redirect_type', ['301', '302'])
                  ->default('301');

            // Social SEO
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();

            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();

            // Schema Markup
            $table->longText('schema_markup')->nullable();

            // Notes
            $table->text('seo_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
