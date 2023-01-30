<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait NormalizesRequests
{
    /**
     * Formats data to Laravel collection.
     * @param array<int>|int|Collection<int> $resourceIds
     * @return Collection<int>
     */
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
