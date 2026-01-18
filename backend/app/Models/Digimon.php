<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Digimon extends Model
{
    protected $table = 'digimons';

    protected $fillable = ['name', 'image_url', 'description'];

    public function skills(){
        return $this->belongsToMany(Skill::class, 'digimons_skills', 'id_digimon', 'id_skill')->withTimestamps();
    }

    public function evolutions(){
        return $this->belongsToMany(DigimonEvolution::class, 'digimon_evolutions', 'id_digimon', 'id_evolution');
    }

    public function evolutions_next(){
        return $this->belongsToMany(Digimon::class, 'digimon_evolutions', 'id_digimon_previous', 'id_digimon_next');
    }

    public function evolutions_previous(){
        return $this->belongsToMany(Digimon::class, 'digimon_evolutions', 'id_digimon_next', 'id_digimon_previous');
    }

}
