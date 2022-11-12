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
        Schema::create('leerdoelables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leerdoel_id')->constrained('leerdoelen');
            $table->foreignId('leerdoelable_id');
            $table->string('leerdoelable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leerdoelables');
    }
};
