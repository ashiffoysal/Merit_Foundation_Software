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
        Schema::create('free_trials', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('child_name');
            $table->unsignedTinyInteger('child_age');
            $table->string('current_level');
            $table->string('tutor_gender')->nullable();
            $table->string('country');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_trials');
    }
};
