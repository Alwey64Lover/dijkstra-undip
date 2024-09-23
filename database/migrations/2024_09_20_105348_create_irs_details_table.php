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
        Schema::create('irs_details', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('irs_id')->nullable()->constrained('irs')->onDelete('set null');
            $table->foreignUlid('course_class_id')->nullable()->constrained('course_classes')->onDelete('set null');
            $table->integer('sks')->default(0);
            $table->string('retrieval_status')->default('baru');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irs_details');
    }
};
