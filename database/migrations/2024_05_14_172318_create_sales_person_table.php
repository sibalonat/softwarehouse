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
        Schema::create('sales_people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->enum('experience', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('cost')->default(0);
            $table->boolean('hired')->default(false);
            $table->boolean('is_busy')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_people');
    }
};
