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
        Schema::create('society_members', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('society_id')->references('id')->on('societies');

            $table->string('email')->unique();

            $table->integer('role');
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->timestamp('renewed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_members');
    }
};
