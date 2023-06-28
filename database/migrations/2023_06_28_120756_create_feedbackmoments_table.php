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
        Schema::create('feedbackmoments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('naam');
            $table->integer('points');
            $table->integer('cesuur');
            $table->longtext('checks');
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
        Schema::dropIfExists('feedbackmoments');
    }
};
