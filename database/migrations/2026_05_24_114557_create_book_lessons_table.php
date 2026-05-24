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
        Schema::create('book_lessons', function (Blueprint $table) {
           $table->id();

            // Parent / Guardian Information
            $table->string('parent_name');
            $table->string('email');
            $table->string('phone');
            $table->string('emergency_phone')->nullable();

            // Address
            $table->text('address');
            $table->string('post_code');

            // Student Information
            $table->string('student_first_name');
            $table->string('student_last_name');
            $table->foreignId('package_id')->constrained('plans')->onDelete('cascade');

            // Lesson Information
            $table->string('current_level')->nullable();
            // Example:
            // Complete Beginner
            // Qaida / Basics
            // Reading Quran
            // Tajweed
            // Hifz (Memorisation)

            $table->enum('preferred_tutor', [
                'Not Specified',
                'Male Tutor',
                'Female Tutor'
            ]);

            $table->string('preferred_time');
            // Morning / Afternoon / Evening / Weekend / Flexible

            // Additional Notes
            $table->text('notes')->nullable();

            // Optional Donation Interest
            $table->boolean('donation_interest')->default(false);

            // Admin Management
            $table->enum('status', [
                'pending',
                'contacted',
                'trial_booked',
                'confirmed',
                'cancelled'
            ])->default('pending');

            $table->text('admin_notes')->nullable();

            $table->timestamp('contacted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_lessons');
    }
};
