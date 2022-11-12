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
        Schema::create('opleidingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams');
            $table->string('eigenaar_id');
            $table->string('naam');
            $table->string('crebo')->nullable();
            $table->boolean('is_actief')->default(true);
            $table->integer('duur_in_jaren');
            $table->integer('blokken_per_jaar');
            $table->timestamps();

            $table->foreign('eigenaar_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opleidingen');
    }
};
