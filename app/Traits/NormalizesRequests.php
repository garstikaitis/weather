<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait NormalizesRequests
{
    private function normalizeRequest(
        array|int|Collection $resourceIds
    ): Collection {
        if (is_int($resourceIds)) {
            return collect($resourceIds);
        }
        if (is_array($resourceIds) && count($resourceIds)) {
            return collect([...$resourceIds]);
        }
        return $resourceIds;
    }
}
