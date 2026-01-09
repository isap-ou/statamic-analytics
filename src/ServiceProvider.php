<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics;

use Illuminate\Support\Facades\Route;
use Isapp\GoogleAnalytics\Analytics\Analytics;
use Isapp\GoogleAnalytics\Controllers\ChartController;
use Isapp\GoogleAnalytics\Controllers\ConfigController;
use Isapp\GoogleAnalytics\Widgets\GoogleAnalytics;
use Spatie\Analytics\AnalyticsClient;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

use function app;
use function class_exists;
use function config;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'google-analytics';

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

    public function register() {}

    public function bootAddon()
    {
        if (! class_exists(\Spatie\Analytics\Contracts\Analytics::class)) {
            $this->app->singleton('laravel-analytics', function () {
                $analyticsConfig = config('analytics');

                $client = app(AnalyticsClient::class);

                return new Analytics($client, $analyticsConfig['property_id']);
            });
        } else {
            $this->app->bind(\Spatie\Analytics\Contracts\Analytics::class, Analytics::class);
        }

        Nav::extend(function ($nav) {
            $nav->settings('Google analytics')
                ->route('isapp-ga.config.index')
                ->icon('shopping-cart');
        });

        $this->registerCpRoutes(function () {
            Route::get('google-analytics', [ConfigController::class, 'index'])->name('isapp-ga.config.index');
            Route::patch('google-analytics', [ConfigController::class, 'update'])->name('isapp-ga.config.update');
            Route::get('charts/{chart?}', ChartController::class)->name('isapp-ga.chart');
        });
    }
}
