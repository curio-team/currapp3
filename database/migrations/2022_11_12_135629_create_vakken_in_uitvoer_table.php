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
        Schema::create('vakken_in_uitvoer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vak_id')->constrained('vakken');
            $table->foreignId('uitvoer_id')->constrained('uitvoeren');
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vakken_in_uitvoer');
    }
};
