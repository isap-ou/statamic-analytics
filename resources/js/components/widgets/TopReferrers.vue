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
        'label': __('isapp-analytics::cp.Referrer'),
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
    :loading="loading"
    :no-data="!data.length"
    header="Top referrers"
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