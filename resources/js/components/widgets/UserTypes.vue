<!--
  - Copyright (c) 2026 ISAPP (isapp.be)
  - All rights reserved.
  -
  - This source code is proprietary and confidential.
  - No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
  -
  - License: Commercial. See LICENSE.md.
  -->

<script setup>
import AnalyticsWrapper from "../common/AnalyticsWrapper.vue";
import { useFetch, widgetProps } from "../../composables/fetch";
import { Card, Listing, Panel } from "@statamic/cms/ui";
import { computed, ref } from "vue";
import { round, sumBy } from "lodash-es";
import VueApexCharts from "vue3-apexcharts";

import { colorMode } from "@statamic/cms/api";

const props = defineProps(widgetProps);
const { loading, data } = useFetch("UserTypes", props);

const columns = ref([
  {
    field: "title",
    label: __("isapp-analytics::cp.Type"),
  },
  {
    field: "users",
    label: __("isapp-analytics::cp.Users"),
    numeric: true,
  },
  {
    field: "share",
    label: __("isapp-analytics::cp.Share"),
  },
]);

const items = computed(() => {
  const total = sumBy(data.value, "activeUsers");
  return data.value.map((item) => ({
    title: __(
      "isapp-analytics::cp." +
        String(item.newVsReturning).charAt(0).toUpperCase() +
        String(item.newVsReturning).slice(1),
    ),
    users: item.activeUsers,
    share: round((item.activeUsers * 100) / total, 2) + "%",
  }));
});

const series = computed(() => data.value.map((item) => item.activeUsers));
const options = computed(() => ({
  theme: {
    mode: colorMode.mode.value,
  },
  legend: {
    position: "top",
  },
  labels: data.value.map((item) =>
    __(
      "isapp-analytics::cp." +
        String(item.newVsReturning).charAt(0).toUpperCase() +
        String(item.newVsReturning).slice(1),
    ),
  ),
}));
</script>

<template>
  <AnalyticsWrapper
    header="New vs Returning Users"
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