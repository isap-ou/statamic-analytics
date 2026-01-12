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
import { useFetch, widgetProps } from "../../composables/fetch.js";
import { Card, Panel } from "@statamic/cms/ui";
import { colorMode } from "@statamic/cms/api";
import { round, sumBy } from "lodash-es";
import { computed, ref } from "vue";
import dayjs from "dayjs";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps(widgetProps);

const { loading, data, request } = useFetch("TotalVisitorsAndPageviews", props);

const users = computed(() => sumBy(data.value, "activeUsers"));
const views = computed(() => sumBy(data.value, "screenPageViews"));
const pagesPerUser = computed(() => round(views.value / users.value, 2));

const series = computed(() => {
  const items = data.value
    .map((item) => ({
      label: dayjs(item.date),
      activeUsers: item.activeUsers || 0,
      screenPageViews: item.screenPageViews || 0,
    }))
    .sort((a, b) => a.label - b.label);

  return [
    {
      data: items.map((item) => item.activeUsers),
      name: __("isapp-analytics::cp.Active users"),
    },
    {
      data: items.map((item) => item.screenPageViews),
      name: __("isapp-analytics::cp.Page views"),
    },
  ];
});
const themeMode = computed(() => {
  return colorMode.mode.value;
});
const chartOptions = computed(() => {
  const items = data.value
    .map((item) => ({
      label: dayjs(item.date),
      activeUsers: item.activeUsers || 0,
      screenPageViews: item.screenPageViews || 0,
    }))
    .sort((a, b) => a.label - b.label);

  return {
    chart: {
      toolbar: {
        show: false,
      },
    },
    stroke: {
      curve: "smooth",
    },
    theme: {
      mode: themeMode.value,
    },
    yaxis: [
      {
        opposite: false,
      },
      {
        opposite: true,
      },
    ],
    xaxis: {
      categories: items.map((item) => item.label.format("DD.MM.YYYY")),
    },
  };
});

const engagement = computed(() => {
  const ratio = pagesPerUser.value;

  if (ratio < 1.5) {
    return __("isapp-analytics::cp.Low");
  }
  if (ratio < 3) {
    return __("isapp-analytics::cp.Medium");
  }
  if (ratio < 5) {
    return __("isapp-analytics::cp.High");
  }
  return __("isapp-analytics::cp.Excellent");
});
</script>
<template>
  <AnalyticsWrapper
    header="Traffic Overview"
    :loading="loading"
    :no-data="!data.length"
  >
    <Panel class="grid grid-cols-4 gap-4 mb-6">
      <Card>
        <div class="text-xs text-gray-500">
          {{ __("isapp-analytics::cp.Active Users") }}
        </div>
        <div class="text-2xl font-semibold">
          {{ users }}
        </div>
      </Card>

      <Card>
        <div class="text-xs text-gray-500">
          {{ __("isapp-analytics::cp.Page Views") }}
        </div>
        <div class="text-2xl font-semibold">
          {{ views }}
        </div>
      </Card>

      <Card>
        <div class="text-xs text-gray-500">
          {{ __("isapp-analytics::cp.Pages / User") }}
        </div>
        <div class="text-2xl font-semibold">
          {{ pagesPerUser }}
        </div>
      </Card>

      <Card>
        <div class="text-xs text-gray-500">
          {{ __("isapp-analytics::cp.Engagement") }}
        </div>
        <div class="text-2xl font-semibold">
          {{ engagement }}
        </div>
      </Card>
    </Panel>

    <Panel v-if="!loading">
      <Card class="aspect-16/9">
        <VueApexCharts
          type="line"
          :series="series"
          :options="chartOptions"
          width="100%"
          class="rounded-xl overflow-hidden"
          height="100%"
        />
      </Card>
    </Panel>
  </AnalyticsWrapper>
</template>
