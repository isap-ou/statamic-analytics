<?php

/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Isapp\GoogleAnalytics\Concerns\HasView;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Statamic\Http\Controllers\CP\CpController;

use function app;
use function method_exists;

class AnalyticsController extends CpController
{
    use HasView;

    public function index()
    {
        return $this->html('analytics');
    }

    public function show(Request $request, string $chart): JsonResponse
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

        $data = Analytics::$method($period, 10000);

        return new JsonResponse($data);
    }
}
