<?php

namespace Municipal\Attestation;

use Illuminate\Support\ServiceProvider;
use Municipal\Attestation\Console\AttestationInstallCommand;
use Municipal\Attestation\Support\LogoHelper;

class AttestationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/attestation.php',
            'attestation'
        );

        // Bind non-singleton logo resolver so changes to SiteSettings apply immediately
        $this->app->bind('attestation.logo', fn () => LogoHelper::url());

        if ($this->app->runningInConsole()) {
            $this->commands([
                AttestationInstallCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if (file_exists(__DIR__ . '/../routes/admin.php')) {
            $this->loadAdminRoutes();
        }
        if (file_exists(__DIR__ . '/../routes/public.php')) {
            $this->loadPublicRoutes();
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'attestation');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/attestation.php' => config_path('attestation.php'),
            ], 'attestation-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/attestation'),
            ], 'attestation-views');

            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/attestation'),
            ], 'attestation-assets');
        }
    }

    protected function loadAdminRoutes(): void
    {
        $routeConfig = config('attestation.routes.admin', []);

        $this->app['router']->group([
            'middleware' => $routeConfig['middleware'] ?? ['web', 'auth'],
            'prefix'     => $routeConfig['prefix'] ?? 'dashboard/attestation',
            'as'         => $routeConfig['name'] ?? 'attestation.',
        ], function () {
            require __DIR__ . '/../routes/admin.php';
        });
    }

    protected function loadPublicRoutes(): void
    {
        $routeConfig = config('attestation.routes.public', []);

        $this->app['router']->group([
            'middleware' => $routeConfig['middleware'] ?? ['web', 'throttle:30,1'],
            'prefix'     => $routeConfig['prefix'] ?? 'attestation',
            'as'         => $routeConfig['name'] ?? 'attestation.',
        ], function () {
            require __DIR__ . '/../routes/public.php';
        });
    }
}
