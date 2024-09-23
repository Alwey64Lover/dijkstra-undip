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
        Schema::create('course_departments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignUlid('academic_year_id')->nullable()->constrained('academic_years')->onDelete('set null');
            $table->string('action_name')->nullable();
            $table->timestamp('action_at')->useCurrent();
            $table->foreignUlid('action_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_departments');
    }
};
