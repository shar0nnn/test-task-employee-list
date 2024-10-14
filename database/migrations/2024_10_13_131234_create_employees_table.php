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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 256);

            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');

            $table->date('hired_at');
            $table->string('phone', 20);
            $table->string('email')->unique();
            $table->decimal('salary')->default(0);
            $table->string('photo')->nullable();

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
        Schema::dropIfExists('employees');
    }
};
