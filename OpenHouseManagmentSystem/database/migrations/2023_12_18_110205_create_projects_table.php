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
          
            $table->bigIncrements('id');

            $table->unsignedBigInteger("fyp_id");
            $table->foreign("fyp_id")->references("id")->on("fyp_groups");
            $table->string('title');
            $table->text('keywords');
            $table->text('description');
            // Add the following line for image captions
            $table->text('image_captions')->nullable();
 
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
