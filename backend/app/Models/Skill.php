<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = ['name', 'description'];

    public function digimons(){
        return $this->belongsToMany(Digimon::class, 'digimons_skills', 'id_skill', 'id_digimon')->withTimestamps();
    }
}
