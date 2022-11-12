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
        Schema::create('acceptatiecriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opleiding_id')->constrained('opleidingen');
            $table->date('datum_start');
            $table->date('datum_eind')->nullable();
            $table->string('tekst_kort');
            $table->text('tekst_lang')->nullable();
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
        Schema::dropIfExists('acceptatiecriteria');
    }
};
