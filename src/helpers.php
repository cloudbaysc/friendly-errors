<?php
if (! function_exists('friendly_errors_incident_id')) {
    function friendly_errors_incident_id(): ?string
    {
        return app()->bound('friendly_errors_incident_id') ? app('friendly_errors_incident_id') : null;
    }
}
