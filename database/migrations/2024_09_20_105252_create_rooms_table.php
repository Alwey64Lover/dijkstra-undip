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
        Schema::create('rooms', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->char('type');
            $table->boolean('is_type_front')->default(true);
            $table->string('name');
            $table->integer('capacity')->default(0);
            $table->string('department')->default(("informatika"));
            $table->string('status')->default('waiting');
            $table->string('isSubmitted')->default(("belum"));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
