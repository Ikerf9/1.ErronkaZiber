<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Punto de registro de servicios en el contenedor de Laravel; actualmente no añade servicios propios.
     */
    public function register(): void
    {
        //
    }

    /**
     * Punto de inicialización tras registrar los servicios; actualmente no ejecuta acciones adicionales.
     */
    public function boot(): void
    {
        //
    }
}
