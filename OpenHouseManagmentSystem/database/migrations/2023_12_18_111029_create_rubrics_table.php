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
        Schema::create('rubrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('met_id')->unsigned();
            $table->string('name');
            $table->text('description');
            

        });
    
        Schema::create('rubric_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rubric_id');
            $table->unsignedBigInteger('project_id');
            $table->integer('rating');
            // Add other relevant fields
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('rubric_id')->references('id')->on('rubrics')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrics');
    }
};
