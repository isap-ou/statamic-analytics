<script>

import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";

export default {
  name: "VisitorsAndPageViewsByDate", components: {Table, Card},
  mixins: [fetch],
  data() {
    return {

      sortColumn: 'activeUsers',
      sortDirection: 'desc',
      columns: [{
        'field': 'title',
        'label': 'Page Title',
        sortable: true,
      }, {
        'field': 'users',
        'label': 'Users',
        numeric: true,
        sortable: true,
      }, {
        'field': 'views',
        'label': 'Views',
        numeric: true,
        sortable: true,
      }, {
        'field': 'pagesPerUser',
        'label': 'Pages/User',
        numeric: true,
        sortable: true,
      }, {
        'field': 'bars',
        'label': 'Trend',
      }]
    }
  }
}
</script>

<template>
  <Card
    header="Top Pages (Engagement)"
    :loading="loading"
  >
    <Table v-bind="{columns, data, sortColumn, sortDirection}"/>
  </Card>
</template>

<style scoped>

</style>