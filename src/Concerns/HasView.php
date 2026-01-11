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

namespace Isapp\GoogleAnalytics\Concerns;

use Illuminate\Support\Carbon;
use Str;

use function collect;
use function config;

trait HasView
{
    use HasConfig;

    /**
     * The HTML that should be shown in the widget.
     */
    public function html(string $view = 'widget'): string|\Illuminate\View\View
    {
        $filterWidgetsKey = $view === 'widget' ? 'is_widget_enabled' : 'is_page_enabled';
        $values = $this->values();

        $widgets = collect($values['widgets'] ?? [])->filter(fn ($item) => ! empty($item[$filterWidgetsKey]));

        if ($widgets->isEmpty()) {
            return '';
        }

        $propertyId = $values['property_id'];
        if (empty($propertyId)) {
            $propertyId = config('analytics.property_id');
            if (empty($propertyId)) {
                return '';
            }
        }

        $range = match ($values['default_date_range'] ?? null) {
            'last_3_days' => [
                'end' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->subDays(3)->format('Y-m-d'),
            ],
            'last_7_days' => [
                'end' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->subDays(7)->format('Y-m-d'),
            ],
            'last_14_days' => [
                'end' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->subDays(14)->format('Y-m-d'),
            ],
            'last_90_days' => [
                'end' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->subDays(90)->format('Y-m-d'),
            ],
            'this_month' => [
                'end' => Carbon::now()->format('Y-m-d'),
                'start' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            ],
            'previous_month' => [
                'start' => Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'),
                'end' => Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d'),
            ],
            default => [
                'start' => Carbon::now()->subMonth()->format('Y-m-d'),
                'end' => Carbon::now()->format('Y-m-d'),
            ]
        };

        $charts = $widgets->pluck('widget')
            ->map(fn ($item) => Str::ucfirst(Str::camel($item)));

        return view('isapp-analytics::' . $view, [
            'property_id' => $values['property_id'] ?? '',
            'charts' => $charts,
            ...$range,
        ]);
    }
}
