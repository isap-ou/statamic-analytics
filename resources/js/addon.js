/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */

import IsappAnalytics from "./components/IsappAnalytics.vue";
import ConfigForm from "./components/ConfigForm.vue";

Statamic.booting(() => {
  Statamic.$components.register("isapp-analytics", IsappAnalytics);
  Statamic.$components.register("isapp-analytics-settings", ConfigForm);
});
