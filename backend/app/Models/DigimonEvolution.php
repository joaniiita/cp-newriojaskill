<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigimonEvolution extends Model
{
    protected $table = 'digimon_evolutions';
    protected $fillable = ['id_digimon_previous', 'id_digimon_next', 'id_evolutionT', 'condition'];

    // Digimon del que partimos, el original
    public function digimon_previous(){
        return $this->belongsTo(Digimon::class, 'id_digimon_previous');
    }

    // Digimon al que pasamos o evolucionamos
    public function digimon_next(){
        return $this->belongsTo(Digimon::class, 'id_digimon_next');
    }

    public function evolution_type(){
        return $this->belongsTo(EvolutionType::class, 'id_evolutionT');
    }
}
