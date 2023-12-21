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
        Schema::create('prefers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_id')->constrained(); // Assuming you have an evaluators table
            $table->string('project_categories');
            $table->text('specialty_areas');
            // Add more fields as needed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefers');
    }
};
