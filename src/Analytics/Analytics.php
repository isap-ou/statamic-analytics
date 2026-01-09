<?php

declare(strict_types = 1);

namespace Isapp\GoogleAnalytics\Analytics;

use Illuminate\Support\Collection;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

use function substr;

class Analytics extends \Spatie\Analytics\Analytics
{
    public function fetchVisitorsAndPageViewsByDate(
        Period $period,
        int $maxResults = 100000,
        $offset = 0,
    ): Collection {
        // Raw rows: fullPageUrl × date → users/views (+ pageTitle for display)
        $rawRows = $this->get(
            period: $period,
            metrics: ['activeUsers', 'screenPageViews'],
            dimensions: ['pageTitle', 'fullPageUrl', 'date'],
            maxResults: $maxResults,
            orderBy: [
                OrderBy::dimension('date'), // asc
            ],
            offset: $offset,
        );

        // Fixed UI constraints
        $topPages = 25;
        $trendBarsCount = 5;

        // Determine bucketing for large ranges (auto)
        $daysInRange = max(1, (int) ceil($period->startDate->diffInDays($period->endDate) + 1));
        $bucketMode = $daysInRange <= 90 ? 'day' : ($daysInRange <= 365 ? 'week' : 'month');

        $bucketKeyFromGaDate = function (string $gaDate, string $mode): string {
            // GA4 Data API often returns dates as YYYYMMDD.
            // Accept YYYY-MM-DD too.
            $normalized = str_contains($gaDate, '-')
                ? $gaDate
                : substr($gaDate, 0, 4) . '-' . substr($gaDate, 4, 2) . '-' . substr($gaDate, 6, 2);

            $dt = new \DateTimeImmutable($normalized);

            if ($mode === 'day') {
                return $dt->format('Y-m-d');
            }

            if ($mode === 'month') {
                return $dt->format('Y-m');
            }

            // week: key is Monday date (Y-m-d)
            // PHP: N = 1 (Mon) .. 7 (Sun)
            $dayOfWeek = (int) $dt->format('N');
            return $dt->modify('-' . ($dayOfWeek - 1) . ' days')->format('Y-m-d');
        };

        // Group rows by page URL and bucket.
        // $pagesByUrl[url] = [
        //   'title' => string,
        //   'totals' => ['users' => int, 'views' => int],
        //   'buckets' => [ bucketKey => ['users' => int, 'views' => int] ]
        // ]
        $pagesByUrl = [];

        foreach ($rawRows as $row) {
            $pageUrl = (string) ($row['fullPageUrl'] ?? '(unknown)');
            $pageTitle = (string) ($row['pageTitle'] ?? '(unknown)');
            $gaDate = (string) ($row['date'] ?? ''); // GA4 often returns YYYYMMDD

            if ($gaDate === '') {
                continue;
            }

            $bucketKey = $bucketKeyFromGaDate($gaDate, $bucketMode);

            if (! isset($pagesByUrl[$pageUrl])) {
                $pagesByUrl[$pageUrl] = [
                    'title' => $pageTitle,
                    'buckets' => [],
                ];
            }

            // Keep the latest known title for the URL.
            $pagesByUrl[$pageUrl]['title'] = $pageTitle;

            if (! isset($pagesByUrl[$pageUrl]['totals'])) {
                $pagesByUrl[$pageUrl]['totals'] = ['users' => 0, 'views' => 0];
            }

            $users = (int) ($row['activeUsers'] ?? 0);
            $views = (int) ($row['screenPageViews'] ?? 0);

            $pagesByUrl[$pageUrl]['totals']['users'] += $users;
            $pagesByUrl[$pageUrl]['totals']['views'] += $views;

            if (! isset($pagesByUrl[$pageUrl]['buckets'][$bucketKey])) {
                $pagesByUrl[$pageUrl]['buckets'][$bucketKey] = ['users' => 0, 'views' => 0];
            }

            $pagesByUrl[$pageUrl]['buckets'][$bucketKey]['users'] += $users;
            $pagesByUrl[$pageUrl]['buckets'][$bucketKey]['views'] += $views;
        }

        // Collect all bucket keys across all pages and sort asc.
        $bucketKeySet = [];
        foreach ($pagesByUrl as $pageData) {
            foreach (array_keys($pageData['buckets']) as $key) {
                $bucketKeySet[$key] = true;
            }
        }

        $timeline = array_keys($bucketKeySet);
        sort($timeline);

        // Keep only the last N buckets for the Trend column.
        if (count($timeline) > $trendBarsCount) {
            $timeline = array_slice($timeline, -$trendBarsCount);
        }

        // Build Top Pages list (table rows)
        $pages = [];

        foreach ($pagesByUrl as $pageUrl => $pageData) {
            $totalUsers = (int) ($pageData['totals']['users'] ?? 0);
            $totalViews = (int) ($pageData['totals']['views'] ?? 0);

            if ($totalUsers === 0 && $totalViews === 0) {
                continue;
            }

            // Trend values (views) aligned to the timeline.
            $trendValues = [];
            foreach ($timeline as $bucketKey) {
                $trendValues[] = (int) ($pageData['buckets'][$bucketKey]['views'] ?? 0);
            }

            // Normalize per page to 0..100 for easy bar rendering.
            $maxValue = max($trendValues ?: [0]);
            $trendBars = array_map(
                fn (int $v) => $maxValue > 0 ? (int) round(($v / $maxValue) * 100) : 0,
                $trendValues
            );

            $pages[] = [
                'key' => $pageUrl,
                'title' => $pageData['title'],
                'users' => $totalUsers,
                'views' => $totalViews,
                'pagesPerUser' => $totalUsers > 0 ? round($totalViews / $totalUsers, 2) : 1,
                'bars' => $trendBars,
            ];
        }

        // Sort by views desc and keep Top 25.
        usort($pages, fn ($a, $b) => ($b['views'] ?? 0) <=> ($a['views'] ?? 0));
        if (count($pages) > $topPages) {
            $pages = array_slice($pages, 0, $topPages);
        }

        return collect($pages);
    }
}
