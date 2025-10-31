<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained('job_listings')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('status', ['applied', 'under_review', 'shortlisted', 'rejected', 'hired'])->default('applied')->index();
            $table->longText('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->timestamps();

            $table->unique(['job_listing_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};