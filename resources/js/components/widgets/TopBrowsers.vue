<script setup>

/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */
import AnalyticsWrapper from "../common/AnalyticsWrapper.vue";
import { useFetch, widgetProps } from "../../composables/fetch";
import { Card, Listing, Panel } from "@statamic/cms/ui";
import { computed, ref } from "vue";
import { round, sumBy } from "lodash-es";
import VueApexCharts from "vue3-apexcharts";

import { colorMode } from "@statamic/cms/api";

const props = defineProps(widgetProps);
const { loading, data } = useFetch("TopBrowsers", props);

const columns = ref([
  {
    field: "browser",
    label: __("isapp-analytics::cp.Browser"),
  },
  {
    field: "screenPageViews",
    label: __("isapp-analytics::cp.Page views"),
    numeric: true,
  },
  {
    field: "share",
    label: __("isapp-analytics::cp.Share"),
  },
]);

const items = computed(() => {
  const total = sumBy(data.value, "screenPageViews");
  return data.value.map((item) => ({
    browser: item.browser,
    screenPageViews: item.screenPageViews,
    share: round((item.screenPageViews * 100) / total, 2) + "%",
  }));
});

const series = computed(() => data.value.map((item) => item.screenPageViews));
const options = computed(() => ({
  theme: {
    mode: colorMode.mode.value,
  },
  legend: {
    position: "top",
  },
  labels: data.value.map((item) => item.browser),
}));
</script>

<template>
  <AnalyticsWrapper
    header="Top Browsers"
    :loading="loading"
    :no-data="!data.length"
  >
    <div class="grid grid-cols-1 lg:grid-cols-5! gap-6">
      <div class="col-span-3">
        <Panel>
          <Card>
            <VueApexCharts
              type="pie"
              :series="series"
              :options="options"
              width="100%"
              class="rounded-xl overflow-hidden"
            />
          </Card>
        </Panel>
      </div>
      <div class="col-span-2">
        <Listing
          :columns
          :items
          :allow-customizing-columns="false"
          :allow-search="false"
        />
      </div>
    </div>
  </AnalyticsWrapper>
</template>
