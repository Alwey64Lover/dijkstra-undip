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
        Schema::create('course_department_details', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_department_id')->nullable()->constrained('course_departments')->onDelete('set null');
            $table->foreignUlid('course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->json('lecturer_ids')->nullable();
            $table->string('status')->nullable();
            $table->integer('semester')->default(1);
            $table->integer('sks');
            $table->integer('max_student');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_department_details');
    }
};
