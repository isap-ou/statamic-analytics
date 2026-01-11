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
import VisitorsAndPageViews from "./widgets/VisitorsAndPageViews.vue";
import VisitorsAndPageViewsByDate from "./widgets/VisitorsAndPageViewsByDate.vue";
import TotalVisitorsAndPageviews from "./widgets/TotalVisitorsAndPageviews.vue";
import MostVisitedPages from "./widgets/MostVisitedPages.vue";
import TopReferrers from "./widgets/TopReferrers.vue";
import UserTypes from "./widgets/UserTypes.vue";
import TopBrowsers from "./widgets/TopBrowsers.vue";
import TopCountries from "./widgets/TopCountries.vue";
import TopOperatingSystems from "./widgets/TopOperatingSystems.vue";

export default {
  components: {
    VisitorsAndPageViews,
    TotalVisitorsAndPageviews,
    VisitorsAndPageViewsByDate,
    MostVisitedPages,
    TopBrowsers,
    TopOperatingSystems,
    TopReferrers,
    TopCountries,
    UserTypes
  },
  props: {
    charts: Array,
    propertyId: Number,
    start: String,
    end: String,
    url: String
  },
  computed: {

    chartOptions() {
      return {
        ...this.range.date,
        url: this.url,
        propertyId: this.propertyId
      }
    },
    darkMode() {
      return Statamic.darkMode;
    },
  },
  data() {
    return {
      pickerConfig: {
        mode: 'range',
        readOnly: true,
        earliest_date: {date: Vue.moment().subtract(3, 'years').format('YYYY-MM-DD')},
        latest_date: {date: Vue.moment().format('YYYY-MM-DD')}
      },
      range: {
        date: {
          start: this.start,
          end: this.end,
        }
      }
    }
  },
  methods: {
    setDate({date}) {
      if (date == null) {
        date = {
          start: this.start,
          end: this.end,
        }
      }
      this.$set(this.range, 'date', date)
    }
  }
}
</script>

<template>
  <div>
    <header class="mb-6">
      <div class="flex items-center">
        <h1 class="flex-1">Google Analytics</h1>

        <date-fieldtype
          class="max-w-96"
          :value="range"
          :config="pickerConfig"
          @input="setDate"
        />
      </div>
    </header>
    <div class="grid grid-cols-1 gap-6">
      <template v-for="chart in charts">
        <component
          :is="chart"
          v-bind="chartOptions"
        />
      </template>
    </div>
  </div>
</template>

<style>
.actions-column {
  display: none;
}
</style>