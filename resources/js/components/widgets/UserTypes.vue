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
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";
import fetch from "../../mixins/fetch";
import {round, sumBy, trim} from "lodash-es";
import chart from "../../mixins/chart";

export default {
  name: "UserTypes",
  methods: {trim},
  mixins: [fetch, pagination, chart],
  components: {Table, Card},
  data() {
    return {

      sortColumn: null,
      sortDirection: 'desc',
      columns: [{
        'field': 'title',
        'label': __('isapp-analytics::cp.Type'),
      }, {
        'field': 'users',
        'label': __('isapp-analytics::cp.Users'),
        numeric: true,
      }, {
        'field': 'share',
        'label': __('isapp-analytics::cp.Share'),
      }]
    }
  },

  computed: {
    items() {
      const total = sumBy(this.data, 'activeUsers')
      return this.data.map(item => ({
        title: __('isapp-analytics::cp.' + String(item.newVsReturning).charAt(0).toUpperCase() + String(item.newVsReturning).slice(1)),
        users: item.activeUsers,
        share: round(item.activeUsers * 100 / total, 2) + '%'
      }))
    },

    chartData() {

      return {
        labels: this.data.map(item => __('isapp-analytics::cp.' + String(item.newVsReturning).charAt(0).toUpperCase() + String(item.newVsReturning).slice(1))),
        datasets: [
          {
            data: this.data.map(item => item.activeUsers),
            backgroundColor: this.chartColors,
            borderColor: this.chartColors,
            hoverOffset: 4
          }]
      }

    },
  }
}
</script>

<template>
  <Card
    :loading="loading"
    :no-data="!data.length"
    header="New vs Returning Users"
  >
    <div class="grid grid-cols-1 lg:flex flex-row gap-6 p-4 items-center justify-center">
      <div class="col-span-2 lg:max-w-72">
        <div v-if="!loading">
          <chart-pie
            :chart-data="chartData"
            :chart-options="{}"
          />
        </div>
      </div>
      <Table
        v-bind="{columns, sortColumn,sortDirection, data: items}"
        no-pagination
        class="col-span-1"
      />
    </div>
  </Card>
</template>