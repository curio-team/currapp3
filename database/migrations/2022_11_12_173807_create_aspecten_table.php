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
        Schema::create('aspecten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leerdoelable_id')->constrained('leerdoelables');
            $table->text('onvoldoende')->nullable();
            $table->text('voldoende');
            $table->text('goed')->nullable();
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
        Schema::dropIfExists('aspecten');
    }
};
