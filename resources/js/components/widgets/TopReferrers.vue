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
import { trim } from "lodash-es";

const props = defineProps(widgetProps);
const { loading, data } = useFetch("TopReferrers", props);

const columns = ref([
  {
    field: "pageReferrer",
    label: __("isapp-analytics::cp.Referrer"),
    sortable: true,
  },
  {
    field: "screenPageViews",
    label: __("isapp-analytics::cp.Page views"),
    numeric: true,
    sortable: true,
  },
]);
const sortColumn = ref("screenPageViews");
const sortDirection = ref("desc");
</script>

<template>
  <AnalyticsWrapper
    header="Top Referrers"
    :loading="loading"
    :no-data="!data.length"
  >
    <StatisticTable :data :columns :sort-direction :sort-column>
      <template #cell-pageReferrer="{ value }">
        <span v-text="trim(value) === '' ? 'Direct / No referrer' : value" />
      </template>
    </StatisticTable>
  </AnalyticsWrapper>
</template>

<style scoped></style>
