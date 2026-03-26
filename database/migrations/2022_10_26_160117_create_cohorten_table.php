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
        Schema::create('cohorten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opleiding_id')->constrained('opleidingen');
            $table->string('naam');
            $table->date('datum_start');
            $table->date('datum_eind');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cohorten');
    }
};
