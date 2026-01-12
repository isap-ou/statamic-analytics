<script setup>
import AnalyticsWrapper from "../common/AnalyticsWrapper.vue";
import { computed, shallowRef } from "vue";
import { useFetch, widgetProps } from "../../composables/fetch.js";
import StatisticTable from "../common/StatisticTable.vue";

const props = defineProps(widgetProps);

const { loading, data, ensureSchema } = useFetch("MostVisitedPages", props);
const columns = shallowRef([
  {
    field: "pageTitle",
    label: __("isapp-analytics::cp.Page"),
    listable: true,
    sortable: true,
  },
  {
    field: "screenPageViews",
    label: __("isapp-analytics::cp.Views"),
    numeric: true,
    sortable: true,
  },
]);
const sortColumn = shallowRef("screenPageViews");
const sortDirection = shallowRef("desc");

const items = computed(() =>
  data.value.map((item) => ({
    url: ensureSchema(item.fullPageUrl),
    ...item,
  })),
);
</script>

<template>
  <AnalyticsWrapper
    header="Most Visited Pages"
    :loading="loading"
    :no-data="!data.length"
  >
    <StatisticTable :data="items" :columns :sort-column :sort-direction>
      <template #cell-pageTitle="{ row: item, value }">
        <a :href="item.url" target="_blank">{{ value }}</a>
      </template>
    </StatisticTable>
  </AnalyticsWrapper>
</template>

<style scoped></style>
