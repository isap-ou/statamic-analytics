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

const { loading, data } = useFetch("VisitorsAndPageViews", props);

const columns = ref([
  {
    field: "pageTitle",
    label: __("isapp-analytics::cp.Page Title"),
    listable: true,
    sortable: true,
  },
  {
    field: "activeUsers",
    label: __("isapp-analytics::cp.Active users"),
    numeric: true,
    sortable: true,
  },
  {
    field: "screenPageViews",
    label: __("isapp-analytics::cp.Page views"),
    numeric: true,
    sortable: true,
  },
]);

const sortColumn = ref("activeUsers");
const sortDirection = ref("desc");
</script>

<template>
  <AnalyticsWrapper
    header="Top Pages (Engagement)"
    :loading="loading"
    :no-data="!data.length"
  >
    <StatisticTable :data :sort-direction :sort-column :columns />
  </AnalyticsWrapper>
</template>
