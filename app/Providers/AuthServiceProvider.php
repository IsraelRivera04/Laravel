<?php

namespace App\Providers;
use App\Models\Juego;
use App\Models\Complemento;
use App\Models\Evento;
use App\Policies\JuegoPolicy;
use App\Policies\ComplementoPolicy;
use App\Policies\EventoPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::policy(Juego::class, JuegoPolicy::class);
        Gate::policy(Complemento::class, ComplementoPolicy::class);
        Gate::policy(Evento::class, EventoPolicy::class);
    }
}
