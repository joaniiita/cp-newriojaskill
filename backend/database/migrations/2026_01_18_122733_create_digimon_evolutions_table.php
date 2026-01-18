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
        Schema::create('digimon_evolutions', function (Blueprint $table) {
            $table->primary(['id_digimon_previous', 'id_digimon_next']);
            $table->foreignId('id_digimon_previous')->constrained('digimons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_digimon_next')->constrained('digimons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_evolutionT')->constrained('evolution_types')->onDelete('cascade')->onUpdate('cascade');
            $table->text('condition');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digimon_evolutions');
    }
};
