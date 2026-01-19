<?php

namespace App\Policies;

use App\Models\Digimon;
use App\Models\EvolutionType;
use App\Models\Skill;
use App\Models\User;

class GenericPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, string $ability){
        if ($user->is_admin){
            return true;
        }
    }

    public function view(User $user, $model){
        return true;
    }

    public function create(User $user){
        if ($user->is_admin){
            return true;
        }
        return false;
    }

    public function update(User $user, $model){
        if ($user->is_admin){
            return true;
        }
        return false;
    }

    public function delete(User $user, $model){
        if ($user->is_admin){
            return true;
        }
        return false;
    }
}
