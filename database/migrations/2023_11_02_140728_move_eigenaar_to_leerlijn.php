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
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('eigenaar_id');
        });

        Schema::table('leerlijnen', function (Blueprint $table) {
            $table->string('eigenaar_id')->nullable();
        });
    }
};
