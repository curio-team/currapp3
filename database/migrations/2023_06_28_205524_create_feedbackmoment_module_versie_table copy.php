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
        Schema::create('feedbackmoment_module_versie', function (Blueprint $table) {
            $table->foreignId('feedbackmoment_id')->constrained('feedbackmoments');
            $table->foreignId('module_versie_id')->constrained('module_versies');
            $table->integer('week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbackmoment_module_versie');
    }
};
