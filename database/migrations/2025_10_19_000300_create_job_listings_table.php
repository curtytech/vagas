<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained('enterprises')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship'])->index();
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('apply_url')->nullable();
            $table->unsignedInteger('access_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};