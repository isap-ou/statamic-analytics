<!--
  - Copyright (c) 2026 ISAPP (isapp.be)
  - All rights reserved.
  -
  - This source code is proprietary and confidential.
  - No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
  -
  - License: Commercial. See LICENSE.md.
  -->

<script>

import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";

export default {
  name: "VisitorsAndPageViewsByDate",
  components: {Table, Card},
  mixins: [fetch, pagination],
  data() {
    return {

      sortColumn: 'views',
      sortDirection: 'desc',
      columns: [{
        'field': 'title',
        'label': __('isapp-analytics::cp.Page Title'),
        sortable: true,
      }, {
        'field': 'users',
        'label': __('isapp-analytics::cp.Users'),
        numeric: true,
        sortable: true,
      }, {
        'field': 'views',
        'label': __('isapp-analytics::cp.Views'),
        numeric: true,
        sortable: true,
      }, {
        'field': 'pagesPerUser',
        'label': __('isapp-analytics::cp.Pages/User'),
        numeric: true,
        sortable: true,
      }, {
        'field': 'bars',
        'label': __('isapp-analytics::cp.Trend'),
      }]
    }
  }
}
</script>

<template>
  <Card
    header="Top Pages (with time buckets)"
    :loading="loading"
    :no-data="!data.length"
  >
    <Table v-bind="{columns, data, sortColumn, sortDirection}">
      <template
        slot="cell-title"
        slot-scope="{ row: item, value }"
      >
        <a
          :href="ensureSchema(item.key)"
          target="_blank"
        >{{ value }}</a>
      </template>
      <template
        slot="cell-bars"
        slot-scope="{ value: bars }"
      >
        <div class="flex items-end space-x-[1px] h-5">
          <div
            v-for="(h, i) in bars"
            :key="i"
            class="w-4 rounded-t-sm bg-[rgb(67,169,255)] dark:bg-[rgb(41,143,230))]"
            :style="{ height: `${Math.max(2, h)}%` }"
          />
        </div>
      </template>
    </Table>
  </Card>
</template>

<style scoped>

</style>