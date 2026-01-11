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
import chart from "../../mixins/chart";
import Card from "../common/Card.vue";
import fetch from "../../mixins/fetch";
import {round, sumBy} from "lodash-es";

export default {
  components: {Card},
  mixins: [chart, fetch],
  name: "TotalVisitorsAndPageviews",
  computed: {
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
            label: __('isapp-analytics::cp.Active users'),
            backgroundColor: this.chartColors[0],
            borderColor: this.chartColors[0],
            cubicInterpolationMode: 'monotone',
            yAxisID: 'y',
          },
          {
            data: data.map(item => item.screenPageViews),
            label: __('isapp-analytics::cp.Page views'),
            backgroundColor: this.chartColors[1],
            borderColor: this.chartColors[1],
            cubicInterpolationMode: 'monotone',
            yAxisID: 'y1',
          }
        ]
      }

    },
    users() {
      return sumBy(this.data, 'activeUsers');
    },
    views() {
      return sumBy(this.data, 'screenPageViews');
    },
    pagesPerUser() {
      return round(this.views / this.users, 2);
    },
    engagement() {
      const ratio = this.pagesPerUser;

      if (ratio < 1.5) {
        return __('isapp-analytics::cp.Low');
      }
      if (ratio < 3) {
        return __('isapp-analytics::cp.Medium');
      }
      if (ratio < 5) {
        return __('isapp-analytics::cp.High');
      }
      return __('isapp-analytics::cp.Excellent');
    }

  }
}
</script>
<template>
  <Card
    :loading="loading"
    :no-data="!data.length"
    header="Traffic Overview"
  >
    <div class="grid grid-cols-4 gap-4 mb-6 p-4">
      <div class="card p-4">
        <div class="text-xs text-gray-500">{{ __('isapp-analytics::cp.Active Users') }}</div>
        <div class="text-2xl font-semibold">{{ users }}</div>
      </div>

      <div class="card p-4">
        <div class="text-xs text-gray-500">{{ __('isapp-analytics::cp.Page Views') }}</div>
        <div class="text-2xl font-semibold">{{ views }}</div>
      </div>

      <div class="card p-4">
        <div class="text-xs text-gray-500">{{ __('isapp-analytics::cp.Pages / User') }}</div>
        <div class="text-2xl font-semibold">{{ pagesPerUser }}</div>
      </div>

      <div class="card p-4">
        <div class="text-xs text-gray-500">{{ __('isapp-analytics::cp.Engagement') }}</div>
        <div class="text-2xl font-semibold">{{ engagement }}</div>
      </div>
    </div>
    <div class="p-6">
      <chart-line
        v-if="!loading"
        :chart-data="chartData"
        :chart-options="chartOptions"
      />
    </div>
  </Card>
</template>