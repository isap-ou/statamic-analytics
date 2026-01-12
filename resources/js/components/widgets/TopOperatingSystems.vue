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
import StatisticTable from "../common/StatisticTable.vue";

const props = defineProps(widgetProps);
const { loading, data } = useFetch("TopOperatingSystems", props);

const columns = ref([
  {
    field: "operatingSystem",
    label: __("isapp-analytics::cp.OS"),
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
    operatingSystem: item.operatingSystem,
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
  labels: data.value.map((item) => item.operatingSystem),
}));
</script>

<template>
  <AnalyticsWrapper
    header="Top operating systems"
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
        <StatisticTable
          :columns
          sort-direction="desc"
          sort-column="screenPageViews"
          :data="items"
          :show-per-page-selector="false"
        />
      </div>
    </div>
  </AnalyticsWrapper>
</template>
