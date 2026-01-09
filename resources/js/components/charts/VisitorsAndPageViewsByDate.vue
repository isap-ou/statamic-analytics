<script>

import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";

export default {
  name: "VisitorsAndPageViewsByDate",
  components: {Card},
  mixins: [fetch],
  computed: {
    chartData() {
      const data = this.data.map(item => ({
        label: Vue.moment(item.date),
        activeUsers: item.activeUsers || 0,
        screenPageViews: item.screenPageViews || 0,
      })).sort((a, b) => a.label - b.label);

      return {
        labels: data.map(item => item.label.format('DD.MM.YYYY')),
        datasets: [
          {
            data: data.map(item => item.activeUsers),
            label: 'Active users',
            backgroundColor: 'rgb(54, 162, 235)',
            borderColor: 'rgb(54, 162, 235)',
            cubicInterpolationMode: 'monotone',
            yAxisID: 'y',
          },
          {
            data: data.map(item => item.screenPageViews),
            label: 'Screen page views',
            backgroundColor: 'rgb(255, 206, 86)',
            cubicInterpolationMode: 'monotone',
            borderColor: 'rgb(255, 206, 86)',
            yAxisID: 'y1',
          }
        ]
      }

    },
    chartOptions() {
      return {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: {
              display: false
            },
            ticks: {
              stepSize: 1
            }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            grid: {
              display: false
            },
            ticks: {
              stepSize: 1
            }
          },
          x: {
            ticks: {
              autoSkip: false,
              callback(value, index, ticks) {
                const maxLabels = 10;
                const step = Math.ceil(ticks.length / maxLabels);

                return index % step === 0 ? this.getLabelForValue(value) : '';
              }
            }
          }
        },
        interaction: {
          intersect: false
        }
      }
    },

  }
}
</script>
<template>
  <Card header="Users & Page Views Over Time">
    <div class="p-6">
      <chart-line
        v-if="!loading"
        :chart-data="chartData"
        :chart-options="chartOptions"
      />
    </div>
  </Card>
</template>