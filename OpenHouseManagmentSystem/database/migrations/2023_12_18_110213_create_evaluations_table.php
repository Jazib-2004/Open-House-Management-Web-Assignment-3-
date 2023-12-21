<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('evaluator_id');
        $table->foreign('evaluator_id')->references('id')->on('evaluators');

        $table->unsignedBigInteger('project_id');
        $table->foreign('project_id')->references('id')->on('projects');
        $table->text('preferences')->nullable();
        $table->integer('rating');
        // Add any other necessary columns for evaluations
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
