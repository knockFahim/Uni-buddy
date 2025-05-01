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
        Schema::create('housing_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('cleanliness_rating')->default(0); // Scale 1-5
            $table->integer('location_rating')->default(0); // Scale 1-5
            $table->integer('value_rating')->default(0); // Scale 1-5
            $table->integer('landlord_rating')->default(0); // Scale 1-5
            $table->integer('safety_rating')->default(0); // Scale 1-5
            $table->decimal('overall_rating', 3, 1)->default(0); // Average of all ratings
            $table->text('review_text')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->boolean('anonymous')->default(false);
            $table->timestamp('stay_start_date')->nullable();
            $table->timestamp('stay_end_date')->nullable();
            $table->timestamps();
            
            // Users can only review a housing post once
            $table->unique(['housing_post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_reviews');
    }
};
