<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cohort_uitvoer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohort_id')->constrained('cohorten');
            $table->foreignId('uitvoer_id')->constrained('uitvoeren');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cohort_uitvoer');
    }
};
