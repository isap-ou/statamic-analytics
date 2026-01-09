<script>
import Card from "../common/Card.vue";
import Table from "../common/Table.vue";
import pagination from "../../mixins/pagination";
import fetch from "../../mixins/fetch";
import {trim} from "lodash-es";

export default {
  name: "TopReferrers",
  methods: {trim},
  mixins: [fetch],
  components: {Card},
  data() {
    return {
    }
  }
}
</script>

<template>
  <Card
    :loading="loading"
    :header="$options.name"
  >
    {{ $options.name}}
  </Card>
</template>