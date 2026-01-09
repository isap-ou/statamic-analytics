<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Analytics;

use Illuminate\Support\Collection;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

use function xdebug_break;

class Analytics extends \Spatie\Analytics\Analytics
{
    public function fetchVisitorsAndPageViewsByDate(
        Period $period,
        int $maxResults = 10,
        $offset = 0
    ): Collection {
        xdebug_break();

        return $this->get(
            period: $period,
            metrics: ['activeUsers', 'screenPageViews'],
            dimensions: ['pageTitle', 'date'],
            maxResults: $maxResults,
            orderBy: [
                OrderBy::dimension('date', false),
            ],
            offset: $offset,
        );
    }
}
