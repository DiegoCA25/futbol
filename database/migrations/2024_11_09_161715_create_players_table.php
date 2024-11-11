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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 80);   // Primer nombre del jugador
            $table->string('last_name', 80);  
            $table->integer('age'); 
            $table->string('position', 50);
            $table->string('description',250);
            $table->string('nationality', 50); 
            $table->string('image',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
