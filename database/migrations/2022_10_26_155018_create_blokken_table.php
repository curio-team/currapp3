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
        Schema::create('blokken', function (Blueprint $table) {
            $table->id();
            $table->string('eigenaar_id')->nullable();
            $table->foreignId('opleiding_id')->constrained('opleidingen');
            $table->string('naam');
            $table->integer('volgorde');
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
        Schema::dropIfExists('blokken');
    }
};
