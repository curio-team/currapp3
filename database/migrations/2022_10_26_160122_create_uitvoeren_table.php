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
        Schema::create('uitvoeren', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained('blokken');
            $table->date('datum_start');
            $table->date('datum_eind');
            $table->integer('schooljaar');
            $table->integer('blok_in_schooljaar');
            $table->integer('points');
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
        Schema::dropIfExists('uitvoeren');
    }
};
