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

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Isapp\GoogleAnalytics\Models\Config;
use Statamic\Facades\YAML;

use function array_merge;
use function storage_path;

trait HasConfig
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
        return storage_path('app/private/google-analytics/google-analytics.yaml');
    }

    protected function getFallbackConfig(): array
    {
        return [
            'default' => [
                'property_id' => config('analytics.property_id'),
            ],
        ];
    }
}
