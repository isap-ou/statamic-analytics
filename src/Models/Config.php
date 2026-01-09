<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Models;

use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\HasAugmentedData;

class Config implements Augmentable
{
    use HasAugmentedData;

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
