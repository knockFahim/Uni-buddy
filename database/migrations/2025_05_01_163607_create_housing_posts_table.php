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
        Schema::create('housing_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('location');
            $table->decimal('rent_amount', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->text('description');
            $table->boolean('is_available')->default(true);
            $table->string('contact_phone')->nullable();
            $table->string('property_type'); // apartment, house, room, etc.
            $table->boolean('utilities_included')->default(false);
            $table->date('available_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_posts');
    }
};
