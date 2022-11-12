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
        Schema::create('module_vak', function (Blueprint $table) {
            $table->foreignId('vak_in_uitvoer_id')->constrained('vakken_in_uitvoer');
            $table->foreignId('module_versie_id')->constrained('module_versies');
            $table->integer('week_start');
            $table->integer('week_eind');
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
        Schema::dropIfExists('module_vak');
    }
};
