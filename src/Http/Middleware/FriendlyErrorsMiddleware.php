<?php

namespace Cloudbay\FriendlyErrors\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Cloudbay\FriendlyErrors\Support\ErrorPageContextResolver;

class FriendlyErrorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            if (config('app.debug')) {
                throw $e; // keep dev DX
            }

            $id = app()->bound('friendly_errors_incident_id') ? app('friendly_errors_incident_id') : null;

            try {
                Log::error($e->getMessage(), [
                    'exception'   => $e,
                    'incident_id' => $id,
                    'url'         => $request->fullUrl(),
                    'user_id'     => optional($request->user())->id,
                ]);
            } catch (\Throwable $ignore) {}

            // Build human context
            $ctx = ['entityRef' => null, 'owner' => null, 'support' => config('friendly-errors.support')];
            try {
                $resolver = app(ErrorPageContextResolver::class);
                $ctx = $resolver->resolve($request) + $ctx;
            } catch (\Throwable $ignore) {}

            // Return HTML for web; JSON for API if expected
            if ($request->expectsJson()) {
                return response()->json([
                    'message'     => 'Something went wrong. Please share this incident ID with support.',
                    'incident_id' => $id,
                    'context'     => array_filter([
                        'item'   => $ctx['entityRef'] ?? null,
                        'owner'  => $ctx['owner'] ?? null,
                    ]),
                    'support'     => $ctx['support'] ?? null,
                ], 500);
            }

            return response()->view(config('friendly-errors.view', 'friendly-errors::errors.500'), [
                'incidentId' => $id,
                'support'    => $ctx['support'] ?? null,
                'entityRef'  => $ctx['entityRef'] ?? null,
                'owner'      => $ctx['owner'] ?? null,
            ], 500);
        }
    }
}
