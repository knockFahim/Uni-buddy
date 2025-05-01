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
        Schema::create('roommate_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('preferred_gender', ['male', 'female', 'any'])->default('any');
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('pets_allowed')->default(false);
            $table->decimal('budget_min', 10, 2)->nullable();
            $table->decimal('budget_max', 10, 2)->nullable();
            $table->string('preferred_location')->nullable();
            $table->boolean('early_bird')->default(false); // Early bird vs night owl
            $table->boolean('partying')->default(false); // Enjoys partying
            $table->boolean('quiet_study')->default(true); // Prefers quiet for studying
            $table->text('additional_preferences')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roommate_preferences');
    }
};
