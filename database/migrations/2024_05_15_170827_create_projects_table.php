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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('sales_people_id')->references('id')->on('sales_people')->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Developer::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Game::class)->constrained()->onDelete('cascade');
            $table->enum('complexity', ['low', 'medium', 'high'])->default('low');
            $table->boolean('is_completed')->default(false);
            $table->integer('value')->default(0);
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
