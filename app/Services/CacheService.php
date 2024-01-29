<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
class CacheService
{
    private const CACHE_EXPIRATION = 3600 * 24 * 30 * 6; // 6 months

    public function cache_data($key, $callback, $expiration = self::CACHE_EXPIRATION, $forget = false) {
        if ($forget) {
            Cache::forget($key);
        }
        return Cache::remember($key, $expiration, $callback);
    }

}
