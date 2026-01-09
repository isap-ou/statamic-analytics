<?php

declare(strict_types=1);

namespace Isapp\StatamicGa\Tests;

use Isapp\StatamicGa\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
