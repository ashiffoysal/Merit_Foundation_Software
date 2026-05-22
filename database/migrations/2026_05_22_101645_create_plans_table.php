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
        Schema::create('plans', function (Blueprint $table) {
             
            $table->id();
            // Basic info
            $table->string('name'); // Standard, Premium, etc.


            // Category
            $table->foreignId('category_id')
                ->constrained('fees_categories')
                ->cascadeOnDelete();

            $table->string('country_code', 2)->default('GB');
            // Class details
            $table->enum('duration', ['30_minutes', '1_hour']);
            $table->integer('days_per_week');
            // Pricing
            $table->decimal('monthly_price', 8, 2);
            $table->string('currency', 3)->default('GBP');
            $table->enum('billing_interval', ['month'])->default('month');
            // About / Description
            $table->string('subtitle')->nullable(); 
            // Example: "Ideal for beginners and younger students"
            $table->text('description')->nullable(); 
            // Full details about the plan
            // Feature list
            $table->json('features')->nullable(); 
            // Example:
            // ["1-to-1 personal lesson", "Qualified tutor", "Progress tracking"]

            // Optional UI fields
            $table->string('badge')->nullable(); 
            // Example: "POPULAR" / "STANDARD"

            $table->string('button_text')->default('Choose Plan');

            // Stripe / Laravel Cashier
            $table->string('stripe_price_id')->unique();
            $table->string('stripe_product_id')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->unique([
                'country_code',
                'duration',
                'days_per_week'
            ]);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
