<?php

namespace Cloudbay\FriendlyErrors;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\LogRecord;
use Cloudbay\FriendlyErrors\Http\Middleware\AttachIncidentId;
use Cloudbay\FriendlyErrors\Http\Middleware\FriendlyErrorsMiddleware;

class FriendlyErrorsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/friendly-errors.php', 'friendly-errors');
    }

    public function boot(): void
    {
        // Views + publish
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'friendly-errors');

        $this->publishes([
            __DIR__.'/../config/friendly-errors.php' => config_path('friendly-errors.php'),
        ], 'friendly-errors-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/friendly-errors'),
        ], 'friendly-errors-views');

        // Add incident_id to Monolog extra[]
        try {
            if (method_exists(Log::getLogger(), 'pushProcessor')) {
                Log::getLogger()->pushProcessor(function (LogRecord $record) {
                    $id = app()->bound('friendly_errors_incident_id') ? app('friendly_errors_incident_id') : null;
                    if ($id) $record->extra['incident_id'] = $id;
                    return $record;
                });
            }
        } catch (\Throwable $e) {}

        // Auto-attach middlewares (can be disabled via config)
        $router = $this->app['router'];
        if (config('friendly-errors.auto_attach_middlewares', true)) {
            $router->pushMiddlewareToGroup('web', AttachIncidentId::class);
            $router->pushMiddlewareToGroup('api', AttachIncidentId::class);
            $router->pushMiddlewareToGroup('web', FriendlyErrorsMiddleware::class);
            $router->pushMiddlewareToGroup('api', FriendlyErrorsMiddleware::class);
        }
    }
}
