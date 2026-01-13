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

use Statamic\Facades\Addon;

trait HasConfig
{
    protected function values(): array
    {
        return Addon::get('isapp/statamic-analytics')->settings()->all();
    }
}
