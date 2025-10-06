<?php

namespace Cloudbay\FriendlyErrors\Support;

use Illuminate\Http\Request;

class ErrorPageContextResolver
{
    public function resolve(Request $request): array
    {
        $support  = config('friendly-errors.support');
        $entityRef = null;
        $owner     = null;

        try {
            $route  = $request->route();
            $params = $route ? $route->parameters() : [];

            foreach (['approval', 'consignment', 'request', 'application'] as $key) {
                if (isset($params[$key])) {
                    $entity = $params[$key];

                    if (is_object($entity)) {
                        $entityRef = class_basename($entity) . ' #' . ($entity->id ?? '—');
                        if (isset($entity->submitter_name))      $owner = $entity->submitter_name;
                        elseif (isset($entity->owner_name))      $owner = $entity->owner_name;
                        elseif (isset($entity->submitted_by_name)) $owner = $entity->submitted_by_name;
                         elseif (isset($entity->created_by)) $owner = $entity->created_by;
                    } else {
                        $entityRef = ucfirst($key) . ' #' . $entity;
                    }
                    break;
                }
            }
        } catch (\Throwable $e) {}

        return compact('support', 'entityRef', 'owner');
    }
}
