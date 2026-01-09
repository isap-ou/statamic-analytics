<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics;

use Illuminate\Support\Facades\Route;
use Isapp\GoogleAnalytics\Analytics\Analytics;
use Isapp\GoogleAnalytics\Controllers\AnalyticsController;
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
            $nav->tools('Analytics')
                ->route('isapp-ga.analytics.index')
                ->icon(
                    '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
</svg>'
                );
        });

        Nav::extend(function ($nav) {
            $nav->settings('Analytics Settings')
                ->route('isapp-ga.config.index')
                ->icon(
                    '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
</svg>'
                );
        });

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'isapp-analytics');

        $this->registerCpRoutes(function () {
            Route::get('google-analytics', [AnalyticsController::class, 'index'])->name('isapp-ga.analytics.index');
            Route::get('isapp-analytics', [ConfigController::class, 'index'])->name('isapp-ga.config.index');
            Route::patch('isapp-analytics', [ConfigController::class, 'update'])
                ->name(
                    'isapp-ga.config.update'
                );
            Route::get('google-analytics/{chart?}', [AnalyticsController::class, 'show'])->name('isapp-ga.chart');
        });
    }
}
