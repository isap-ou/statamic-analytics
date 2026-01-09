<script>
import VisitorsAndPageViews from "./widgets/VisitorsAndPageViews.vue";
import VisitorsAndPageViewsByDate from "./widgets/VisitorsAndPageViewsByDate.vue";
import TotalVisitorsAndPageviews from "./widgets/TotalVisitorsAndPageviews.vue";
import MostVisitedPages from "./widgets/MostVisitedPages.vue";
import TopReferrers from "./widgets/TopReferrers.vue";
import UserTypes from "./widgets/UserTypes.vue";

export default {
  components: {
    VisitorsAndPageViews,
    TotalVisitorsAndPageviews,
    VisitorsAndPageViewsByDate,
    MostVisitedPages,
    TopReferrers,
    UserTypes
  },
  props: {
    charts: Array,
    propertyId: String,
    url: String
  }, computed: {

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
        earliest_date: {date: Vue.moment().subtract(3, 'years').format('YYYY-MM-DD')},
        latest_date: {date: Vue.moment().format('YYYY-MM-DD')}
      },
      range: {
        date: {
          start: Vue.moment().subtract(1, 'months').format('YYYY-MM-DD'),
          end: Vue.moment().subtract(1, 'days').format('YYYY-MM-DD'),
        }
      }
    }
  },
  methods: {
    setDate({date}) {
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