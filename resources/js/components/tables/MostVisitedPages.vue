<script>
import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";
import Table from "../common/Table.vue";

export default {
  name: "MostVisitedPages",
  components: {Table, Card},
  mixins: [fetch],
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
      const ensureSchema = (url) => {
        if (!url) return url;

        // если схема уже есть — не трогаем
        if (/^[a-z]+:\/\//i.test(url)) {
          return url;
        }

        return `https://${url}`;
      }
      return this.data.map(item => ({
        url: ensureSchema(item.fullPageUrl),
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
          class="text-blue"
        >{{ value }}</a>
      </template>
    </Table>
  </Card>
</template>

<style scoped>

</style>