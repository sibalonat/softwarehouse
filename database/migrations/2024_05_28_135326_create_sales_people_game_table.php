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
        Schema::create('sales_people_game', function (Blueprint $table) {
            $table->foreignId('sales_people_id')->constrained('sales_people');
            $table->foreignId('game_id')->constrained('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_people_game');
    }
};
