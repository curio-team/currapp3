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
        Schema::create('leerdoelen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leerlijn_id')->constrained('leerlijnen');
            $table->integer('volgorde');
            $table->integer('nummer');
            $table->string('tekst_kort');
            $table->text('tekst_lang');
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
        Schema::dropIfExists('leerdoelen');
    }
};
