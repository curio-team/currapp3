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
        Schema::create('acceptatiecriterium_leerlijn', function (Blueprint $table) {
            $table->foreignId('acceptatiecriterium_id')->constrained('acceptatiecriteria');
            $table->foreignId('leerlijn_id')->constrained('leerlijnen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acceptatiecriterium_leerlijn');
    }
};
