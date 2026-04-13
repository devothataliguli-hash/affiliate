<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Affiliate Marketing", "Biashara Ndogo"
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('video_url')->nullable(); // YouTube or uploaded video path
            $table->text('notes')->nullable(); // Rich text content
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};