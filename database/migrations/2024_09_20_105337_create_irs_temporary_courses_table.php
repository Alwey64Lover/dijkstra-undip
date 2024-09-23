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
        Schema::create('irs_temporary_courses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('her_registration_id')->nullable()->constrained('her_registrations')->onDelete('set null');
            $table->json('course_ids')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irs_temporary_courses');
    }
};
