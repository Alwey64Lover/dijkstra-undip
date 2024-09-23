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
        Schema::create('her_registrations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->foreignUlid('academic_year_id')->nullable()->constrained('academic_years')->onDelete('set null');
            $table->integer('semester')->default(1);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('her_registrations');
    }
};
