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

namespace Isapp\GoogleAnalytics;

use Illuminate\Support\Facades\Route;
use Isapp\GoogleAnalytics\Analytics\Analytics;
use Isapp\GoogleAnalytics\Controllers\AnalyticsController;
use Isapp\GoogleAnalytics\Widgets\GoogleAnalytics;
use Spatie\Analytics\AnalyticsClient;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

use function app;
use function config;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'isapp-analytics';

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $widgets = [
        GoogleAnalytics::class,
    ];

    public function bootAddon()
    {
        $this->registerSettingsBlueprint([
            'tabs' => [
                'main' => [
                    'sections' => [
                        [
                            'fields' => [
                                [
                                    'handle' => 'property_id',
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Property ID',
                                        'validate' => ['required', 'integer'],
                                    ],
                                ],
                                [
                                    'handle' => 'handle',
                                    'field' => ['type' => 'hidden', 'default' => 'default'],
                                ],
                                [
                                    'handle' => 'default_date_range',
                                    'field' => [
                                        'type' => 'select',
                                        'display' => 'isapp-analytics::cp.DefaultDateRange',
                                        'instructions' => 'isapp-analytics::cp.DefaultDateRangeInstructions',
                                        'default' => 'last_30_days',
                                        'options' => [
                                            'last_3_days' => 'isapp-analytics::cp.Last 3 days',
                                            'last_7_days' => 'isapp-analytics::cp.Last 7 days',
                                            'last_14_days' => 'isapp-analytics::cp.Last 14 days',
                                            'last_30_days' => 'isapp-analytics::cp.Last 30 days',
                                            'last_90_days' => 'isapp-analytics::cp.Last 90 days',
                                            'this_month' => 'isapp-analytics::cp.This month',
                                            'previous_month' => 'isapp-analytics::cp.Previous month',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'display' => 'isapp-analytics::cp.WidgetsHeadline',
                            'instructions' => 'isapp-analytics::cp.WidgetsInstructions',
                            'fields' => [
                                [
                                    'handle' => 'widgets',
                                    'field' => [
                                        'type' => 'grid',
                                        'add_row' => 'isapp-analytics::cp.AddWidget',
                                        'fields' => [
                                            [
                                                'handle' => 'widget',
                                                'field' => [
                                                    'type' => 'select',
                                                    'display' => 'isapp-analytics::cp.Widget',
                                                    'placeholder' => 'isapp-analytics::cp.SelectWidget',
                                                    'options' => [
                                                        'visitors_and_page_views' => 'isapp-analytics::cp.Visitors and page views',
                                                        'visitors_and_page_views_by_date' => 'isapp-analytics::cp.Visitors and page views by date',
                                                        'total_visitors_and_pageviews' => 'isapp-analytics::cp.Total visitors and pageviews',
                                                        'most_visited_pages' => 'isapp-analytics::cp.Most visited pages',
                                                        'top_referrers' => 'isapp-analytics::cp.Top Referrers',
                                                        'user_types' => 'isapp-analytics::cp.User Types',
                                                        'top_browsers' => 'isapp-analytics::cp.Top browsers',
                                                        'top_countries' => 'isapp-analytics::cp.Top countries',
                                                        'top_operating_systems' => 'isapp-analytics::cp.Top operating systems',
                                                    ],
                                                    'validate' => ['required'],
                                                ],
                                            ],
                                            [
                                                'handle' => 'is_widget_enabled',
                                                'field' => [
                                                    'type' => 'toggle',
                                                    'display' => 'isapp-analytics::cp.On Dashboard',
                                                    'default' => false,
                                                ],
                                            ],
                                            [
                                                'handle' => 'is_page_enabled',
                                                'field' => [
                                                    'type' => 'toggle',
                                                    'display' => 'isapp-analytics::cp.On Analytics Page',
                                                    'default' => false,
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $this->app->singleton('laravel-analytics', function () {
            $analyticsConfig = config('analytics');

            $client = app(AnalyticsClient::class);

            return new Analytics($client, $analyticsConfig['property_id']);
        });

        Nav::extend(function ($nav) {
            $nav->tools('Analytics')
                ->route('isapp-ga.analytics.index')
                ->icon(
                    '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
</svg>'
                );
        });

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'isapp-analytics');

        $this->registerCpRoutes(function () {
            Route::get('isapp-analytics', [AnalyticsController::class, 'index'])->name('isapp-ga.analytics.index');
            Route::get('isapp-analytics/{chart?}', [AnalyticsController::class, 'show'])->name('isapp-ga.chart');
        });
    }
}
