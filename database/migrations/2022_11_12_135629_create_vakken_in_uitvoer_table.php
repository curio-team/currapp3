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
        Schema::create('vakken_in_uitvoer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vak_id')->constrained('vakken');
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
        Schema::dropIfExists('vakken_in_uitvoer');
    }
};
