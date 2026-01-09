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
        'label': 'Type',
      }, {
        'field': 'users',
        'label': 'Users',
        numeric: true,
      }, {
        'field': 'share',
        'label': 'Share',
      }]
    }
  },

  computed: {
    items() {
      const total = sumBy(this.data, 'activeUsers')
      return this.data.map(item => ({
        title: String(item.newVsReturning).charAt(0).toUpperCase() + String(item.newVsReturning).slice(1),
        users: item.activeUsers,
        share: round(item.activeUsers * 100 / total, 2) + '%'
      }))
    },

    chartData() {

      return {
        labels: this.data.map(item => String(item.newVsReturning).charAt(0).toUpperCase() + String(item.newVsReturning).slice(1)),
        datasets: [
          {
            data: this.data.map(item => item.activeUsers),
            backgroundColor: [
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)',
              'rgb(255, 99, 132)',
            ],
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
    header="Top Referrers"
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

<style scoped>

</style>