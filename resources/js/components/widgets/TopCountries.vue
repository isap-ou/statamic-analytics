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
  name: "TopCountries",
  methods: {trim},
  mixins: [fetch, pagination, chart],
  components: {Table, Card},
  data() {
    return {

      sortColumn: 'screenPageViews',
      sortDirection: 'desc',
      columns: [{
        'field': 'country',
        'label': __('isapp-analytics::cp.Country'),
      }, {
        'field': 'screenPageViews',
        'label': __('isapp-analytics::cp.Page views'),
        numeric: true,
      }, {
        'field': 'share',
        'label': __('isapp-analytics::cp.Share'),
      }]
    }
  },

  computed: {
    items() {
      const total = sumBy(this.data, 'screenPageViews')
      return this.data.map(item => ({
        country: item.country,
        screenPageViews: item.screenPageViews,
        share: round(item.screenPageViews * 100 / total, 2) + '%'
      }))
    },

    chartData() {

      return {
        labels: this.data.map(item => item.country),
        datasets: [
          {
            data: this.data.map(item => item.screenPageViews),
            backgroundColor: this.chartColors,
            borderWidth: 0,
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
    header="Top Countries"
  >

    <div class="grid grid-cols-1 lg:flex flex-row gap-6 p-4 items-center justify-center">

      <div class="col-span-2 lg:max-w-112 lg:w-full">
        <div v-if="!loading">
          <chart-pie
            :chart-data="chartData"
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