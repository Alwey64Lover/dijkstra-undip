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
        Schema::create('irs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('her_registration_id')->nullable()->constrained('her_registrations')->onDelete('set null');
            $table->string('status_name')->default('opened');
            $table->timestamp('status_at')->useCurrent();
            $table->foreignUlid('status_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action_name')->default('rejected');
            $table->string('action_at')->useCurrent();
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
        Schema::dropIfExists('irs');
    }
};
