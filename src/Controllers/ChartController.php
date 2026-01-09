<?php

declare(strict_types = 1);

namespace Isapp\GoogleAnalytics\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Statamic\Http\Controllers\CP\CpController;

use function app;
use function method_exists;

class ChartController extends CpController
{
    public function __invoke(Request $request, string $chart)
    {
        $validated = $request->validate([
            'property_id' => ['required', 'string'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
        ]);

        $method = 'fetch' . $chart;

        if (! method_exists(\Isapp\GoogleAnalytics\Analytics\Analytics::class, $method)) {
            return new JsonResponse(status: 404);
        }

        app()->make('config')->set('analytics.property_id', $validated['property_id']);

        $period = Period::create(Carbon::parse($validated['start']), Carbon::parse($validated['end']));

        $data = match ($chart) {
            'VisitorsAndPageViews', 'MostVisitedPages' => Analytics::$method($period, 1000),
            default => Analytics::$method($period, 10000)
        };

        return new JsonResponse($data);
    }
}
