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
  name: "MostVisitedPages",
  components: {Table, Card},
  mixins: [fetch, pagination],
  data() {
    return {
      sortColumn: 'screenPageViews',
      sortDirection: 'desc',
      columns: [{
        'field': 'pageTitle',
        'label': __('isapp-analytics::cp.Page'),
        listable: true,
        sortable: true,
      }, {
        'field': 'screenPageViews',
        'label': __('isapp-analytics::cp.Views'),
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
    :no-data="!data.length"
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