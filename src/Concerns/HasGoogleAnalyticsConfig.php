<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Isapp\GoogleAnalytics\Models\Config;
use Statamic\Facades\YAML;

use function array_merge;

trait HasGoogleAnalyticsConfig
{
    protected function hydrateConfig($config): Collection
    {
        $defaultSiteHandle = 'default';

        return collect($config)->map(
            fn ($config, $handle) => new Config($handle, $config, $handle === $defaultSiteHandle)
        );
    }

    protected function setSites($sites = null): Collection
    {
        $sites ??= $this->getSavedSites();

        return $this->hydrateConfig($sites);
    }

    protected function values(): array
    {
        $sites ??= $this->getSavedSites();

        $config = $this->hydrateConfig($sites)
            ->keyBy
            ->handle()
            ->map
            ->rawConfig()
            ->all();

        return collect($config)
            ->map(fn ($site, $handle) => array_merge(['handle' => $handle], $site))
            ->values()
            ->first();
    }

    protected function getSavedSites()
    {
        return File::exists($sitesPath = $this->path())
            ? YAML::file($sitesPath)->parse()
            : $this->getFallbackConfig();
    }

    protected function path(): string
    {
        return resource_path('google-analytics.yaml');
    }

    protected function getFallbackConfig(): array
    {
        return [
            'default' => [],
        ];
    }
}
