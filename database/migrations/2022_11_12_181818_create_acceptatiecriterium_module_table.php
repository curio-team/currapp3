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
        Schema::create('acceptatiecriterium_module', function (Blueprint $table) {
            $table->foreignId('acceptatiecriterium_id')->constrained('acceptatiecriteria');
            $table->foreignId('module_versie_id')->constrained('module_versies');
            $table->string('reviewer_id')->nullable();
            $table->boolean('voldoet')->default(false);
            $table->string('opmerking')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acceptatiecriterium_module');
    }
};
