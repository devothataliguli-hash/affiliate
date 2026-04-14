<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            // Only add columns that are not already present
            if (!Schema::hasColumn('skills', 'platform_link')) {
                $table->string('platform_link')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('skills', 'pdf_file')) {
                $table->string('pdf_file')->nullable()->after('platform_link');
            }
            if (!Schema::hasColumn('skills', 'voice_file')) {
                $table->string('voice_file')->nullable()->after('pdf_file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['platform_link', 'pdf_file', 'voice_file']);
        });
    }
};