<!--
  - Copyright (c) 2026 ISAPP (isapp.be)
  - All rights reserved.
  -
  - This source code is proprietary and confidential.
  - No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
  -
  - License: Commercial. See LICENSE.md.
  -->

<script setup>
import { parseAbsoluteToLocal } from "@internationalized/date";
import { defineAsyncComponent, ref, shallowRef } from "vue";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import { DateRangePicker, Header } from "@statamic/cms/ui";

dayjs.extend(utc);

const widgets = import.meta.glob("./widgets/*.vue");
let tmpComponents = {};

for (let [path] of Object.entries(widgets)) {
  const componentName = path
    .split("/")
    .pop()
    .replace(/\.\w+$/, "");
  tmpComponents[componentName] = defineAsyncComponent(
    () => import(`./widgets/${componentName}.vue`),
  );
}

const components = shallowRef(tmpComponents);

const props = defineProps({
  charts: { type: Array, default: () => [] },
  propertyId: { type: Number, default: null },
  start: { type: String, default: null },
  end: { type: String, default: null },
  url: { type: String, default: null },
});

const range = ref({
  start: parseAbsoluteToLocal(dayjs(props.start).utc().format()),
  end: parseAbsoluteToLocal(dayjs(props.end).utc().format()),
});
</script>

<template>
  <div class="max-w-7xl mx-auto">
    <Header :title="__('isapp-analytics::cp.Analytics (GA4)')" icon="chart-monitoring-indicator" class="pb-4!">
      <DateRangePicker
        v-model="range"
        granularity="day"
        :max="parseAbsoluteToLocal(dayjs().utc().format())"
      />
    </Header>

    <div class="grid grid-cols-1 gap-6">
      <template v-for="chart in charts" :key="chart">
        <div v-if="components[chart] != null">
          <component
            :is="components[chart]"
            v-bind="{ ...range, url: props.url, propertyId: props.propertyId }"
          />
        </div>
      </template>
    </div>
  </div>
</template>
