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
        Schema::create('fyp_groups', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('group_name');
            $table->string('email',255)->unique();
            $table->string('password',255);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fyp_groups');
    }
};
