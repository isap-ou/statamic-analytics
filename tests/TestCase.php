<?php

declare(strict_types=1);

namespace Isapp\GoogleAnalytics\Tests;

use Isapp\StatamicGa\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
