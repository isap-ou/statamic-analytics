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
