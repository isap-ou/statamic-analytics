/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */

import GoogleAnalytics from "./components/GoogleAnalytics.vue";
import ConfigForm from "./components/ConfigForm.vue";
import {Line, Bar, Pie} from "vue-chartjs/legacy";

Statamic.booting(() => {
    Statamic.$components.register("isapp-analytics", GoogleAnalytics);
    Statamic.$components.register("isapp-analytics-settings", ConfigForm);
    Statamic.$components.register("chart-line", Line);
    Statamic.$components.register("chart-bar", Bar);
    Statamic.$components.register("chart-pie", Pie);
});