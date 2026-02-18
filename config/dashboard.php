<?php

return [
    'cache' => [
        'ttl' => env('DASHBOARD_CACHE_TTL', 3600),
    ],
    'monitoring' => [
        'slow_query_threshold' => env('DASHBOARD_SLOW_QUERY_THRESHOLD', 500), // milliseconds
    ],
];
