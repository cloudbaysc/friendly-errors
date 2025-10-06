<?php

namespace Cloudbay\FriendlyErrors\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttachIncidentId
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->headers->get('X-Incident-Id') ?: Str::ulid();
        app()->instance('friendly_errors_incident_id', (string) $id);
        $request->headers->set('X-Incident-Id', $id);

        return $next($request);
    }
}
