<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvolutionType extends Model
{
    protected $table = 'evolution_types';
    protected $fillable = ['name', 'description', 'ranking'];

    public function digimon_evolutions(){
        return $this->hasMany(DigimonEvolution::class, 'id_evolutionT');
    }
}
