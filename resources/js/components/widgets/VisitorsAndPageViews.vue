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
import fetch from "../../mixins/fetch";

export default {
  name: "VisitorsAndPageViews",
  components: {Table, Card},
  mixins: [fetch],
  data() {
    return {

      sortColumn: 'activeUsers',
      sortDirection: 'desc',
      columns: [{
        'field': 'pageTitle',
        'label': __('isapp-analytics::cp.Page Title'),
        listable: true,
        sortable: true,
      }, {
        'field': 'activeUsers',
        'label': __('isapp-analytics::cp.Active users'),
        numeric: true,
        sortable: true,
      }, {
        'field': 'screenPageViews',
        'label': __('isapp-analytics::cp.Page views'),
        numeric: true,
        sortable: true,
      }]
    }
  }
}
</script>

<template>
  <Card
    header="Top Pages (Engagement)"
    :loading="loading"
    :no-data="!data.length"
  >
    <Table v-bind="{columns, data, sortColumn, sortDirection}"/>
  </Card>
</template>

<style scoped>

</style>