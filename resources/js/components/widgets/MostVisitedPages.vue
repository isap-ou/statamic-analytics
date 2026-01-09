<script>
import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";

export default {
  name: "MostVisitedPages",
  components: {Table, Card},
  mixins: [fetch, pagination],
  data() {
    return {
      sortColumn: 'screenPageViews',
      sortDirection: 'desc',
      columns: [{
        'field': 'pageTitle',
        'label': 'Page',
        listable: true,
        sortable: true,
      }, {
        'field': 'screenPageViews',
        'label': 'View',
        numeric: true,
        sortable: true,
      }]
    }
  },
  computed: {
    items() {
      return this.data.map(item => ({
        url: this.ensureSchema(item.fullPageUrl),
        ...item
      }))
    }
  }
}
</script>

<template>
  <Card
    :loading="loading"
    header="Most Visited Pages"
  >
    <Table v-bind="{columns, data: items, sortColumn, sortDirection}">
      <template
        slot="cell-pageTitle"
        slot-scope="{ row: item, value }"
      >
        <a
          :href="item.url"
          target="_blank"
        >{{ value }}</a>
      </template>
    </Table>
  </Card>
</template>

<style scoped>

</style>