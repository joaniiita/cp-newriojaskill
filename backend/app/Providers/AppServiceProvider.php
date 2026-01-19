<?php

namespace App\Providers;

use App\Models\Digimon;
use App\Models\DigimonEvolution;
use App\Models\EvolutionType;
use App\Models\Skill;
use App\Policies\GenericPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Digimon::class, GenericPolicy::class);
        Gate::policy(Skill::class, GenericPolicy::class);
        Gate::policy(EvolutionType::class, GenericPolicy::class);
        Gate::policy(DigimonEvolution::class, GenericPolicy::class);
    }
}
