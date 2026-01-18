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
        Schema::create('digimons_skills', function (Blueprint $table) {
            $table->foreignId('id_digimon')->constrained('digimons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_skill')->constrained('skills')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['id_digimon', 'id_skill']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digimons_skills');
    }
};
