<script>
import Card from "../common/Card.vue";
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";
import fetch from "../../mixins/fetch";
import {round, sumBy, trim} from "lodash-es";
import chart from "../../mixins/chart";

export default {
  name: "TopBrowsers",
  methods: {trim},
  mixins: [fetch, pagination, chart],
  components: {Table, Card},
  data() {
    return {

      sortColumn: 'screenPageViews',
      sortDirection: 'desc',
      columns: [{
        'field': 'browser',
        'label': __('isapp-analytics::cp.Browser'),
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
        browser: item.browser,
        screenPageViews: item.screenPageViews,
        share: round(item.screenPageViews * 100 / total, 2) + '%'
      }))
    },

    chartData() {

      return {
        labels: this.data.map(item => item.browser),
        datasets: [
          {
            data: this.data.map(item => item.screenPageViews),
            backgroundColor: this.chartColors,
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
    header="Top Browsers"
  >

    <div class="grid grid-cols-1 lg:flex flex-row gap-6 p-4 items-center justify-center">

      <div class="col-span-2 lg:max-w-72">
        <div v-if="!loading">
          <chart-pie
            :chart-data="chartData"
            :chart-options="chartOptions"
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