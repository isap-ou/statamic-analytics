<script>
import Card from "../common/Card.vue";
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";
import fetch from "../../mixins/fetch";
import {trim} from "lodash-es";

export default {
  name: "TopReferrers",
  methods: {trim},
  mixins: [fetch, pagination],
  components: {Table, Card},
  data() {
    return {

      sortColumn: 'screenPageViews',
      sortDirection: 'desc',
      columns: [{
        'field': 'pageReferrer',
        'label': 'Referrer',
        sortable: true,
      }, {
        'field': 'screenPageViews',
        'label': 'Page views',
        numeric: true,
        sortable: true,
      }]
    }
  }
}
</script>

<template>
  <Card
    :loading="loading"
    header=""
  >
    <Table v-bind="{columns, sortColumn,sortDirection, data}">
      <template
        slot="cell-pageReferrer"
        slot-scope="{ row: item, value }"
      >
        <span v-text="trim(value) === ''? 'Direct / No referrer': value "></span>
      </template>
    </Table>
  </Card>
</template>