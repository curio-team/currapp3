<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vakken_in_uitvoer', function (Blueprint $table) {
            $table->foreignId('gelinkt_aan_vak_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vakinuitvoer', function (Blueprint $table) {
            //
        });
    }
};
