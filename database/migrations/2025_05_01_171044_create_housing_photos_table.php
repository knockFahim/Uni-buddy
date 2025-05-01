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
        Schema::create('housing_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_post_id')->constrained()->onDelete('cascade');
            $table->string('file_path'); // Path to the stored image
            $table->string('file_name'); // Original filename
            $table->string('caption')->nullable(); // Optional caption for the image
            $table->boolean('is_primary')->default(false); // Is this the primary/cover image
            $table->unsignedInteger('sort_order')->default(0); // For ordering images
            $table->string('mime_type'); // Image MIME type
            $table->unsignedInteger('file_size'); // Image size in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_photos');
    }
};
