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
        Schema::create('taken', function (Blueprint $table) {
            $table->id();
            $table->string('eigenaar_id');
            $table->foreignId('opleiding_id')->constrained('opleidingen');
            $table->string('naam');
            $table->string('omschrijving')->nullable();
            $table->integer('voortgang')->default(0);
            $table->boolean('afgerond')->default(false);
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
        Schema::dropIfExists('taken');
    }
};
