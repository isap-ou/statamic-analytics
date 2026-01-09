<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics;

use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\HasAugmentedData;

class GoogleAnalyticsConfig implements Augmentable
{
    use HasAugmentedData;

    protected $config;

    public function __construct(protected $handle, protected $rawConfig, protected $isDefault = false) {}

    public function handle()
    {
        return $this->handle;
    }

    public function rawConfig()
    {
        return $this->rawConfig;
    }
}
