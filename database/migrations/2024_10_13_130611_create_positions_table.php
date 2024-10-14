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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);

            $table->unsignedBigInteger('admin_created_id')->nullable();
            $table->foreign('admin_created_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('admin_updated_id')->nullable();
            $table->foreign('admin_updated_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
