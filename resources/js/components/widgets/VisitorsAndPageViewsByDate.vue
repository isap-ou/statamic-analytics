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
import StatisticTable from "../common/StatisticTable.vue";
import { useFetch, widgetProps } from "../../composables/fetch";
import { ref } from "vue";

const props = defineProps(widgetProps);

const { loading, data } = useFetch("VisitorsAndPageViewsByDate", props);
const columns = ref([
  {
    field: "title",
    label: __("isapp-analytics::cp.Page Title"),
    sortable: true,
  },
  {
    field: "users",
    label: __("isapp-analytics::cp.Users"),
    numeric: true,
    sortable: true,
  },
  {
    field: "views",
    label: __("isapp-analytics::cp.Views"),
    numeric: true,
    sortable: true,
  },
  {
    field: "pagesPerUser",
    label: __("isapp-analytics::cp.Pages/User"),
    numeric: true,
    sortable: true,
  },
  {
    field: "bars",
    label: __("isapp-analytics::cp.Trend"),
  },
]);

const sortColumn = ref("views");
const sortDirection = ref("desc");

function ensureSchema(url) {
  if (!url) return url;

  if (/^[a-z]+:\/\//i.test(url)) {
    return url;
  }

  return `https://${url}`;
}
</script>

<template>
  <AnalyticsWrapper
    header="Top Pages (with time buckets)"
    :loading="loading"
    :no-data="!data.length"
  >
    <StatisticTable
      :data="data"
      :columns="columns"
      :sort-column="sortColumn"
      :sort-direction="sortDirection"
    >
      <template #cell-title="{ row, value }">
        <a :href="ensureSchema(row.key)" target="_blank">{{ value }}</a>
      </template>
      <template #cell-bars="{ value: bars }">
        <div class="flex items-end space-x-px h-5">
          <div
            v-for="(h, i) in bars"
            :key="i"
            class="w-4 rounded-t-sm bg-ui-accent-text dark:bg-ui-accent-text"
            :style="{ height: `${Math.max(2, h)}%` }"
          />
        </div>
      </template>
    </StatisticTable>
  </AnalyticsWrapper>
</template>

<style scoped></style>
