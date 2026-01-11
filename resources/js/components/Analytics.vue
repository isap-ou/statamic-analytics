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

import {DateRangePicker, Header} from "@statamic/cms/ui";
import {parseAbsoluteToLocal} from '@internationalized/date'
import {defineAsyncComponent, ref} from "vue";
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'

dayjs.extend(utc);

const widgets = import.meta.glob('./widgets/*.vue');

const components = {};

Object.entries(widgets).forEach(([path]) => {
  const componentName = path
  .split('/')
  .pop()
  .replace(/\.\w+$/, '');

  components[componentName] = defineAsyncComponent(() => import(`./widgets/${componentName}.vue`));
});

const props = defineProps({
  charts: Array,
  propertyId: Number,
  start: String,
  end: String,
  url: String
})

const range = ref({
  start: parseAbsoluteToLocal(dayjs(props.start).utc().format()),
  end: parseAbsoluteToLocal(dayjs(props.end).utc().format()),
})

</script>

<template>

  <div class="max-w-5xl mx-auto">
    <Header
      :title="__('isapp-analytics::cp.Analytics (GA4)')"
      icon="site"
    >
      <DateRangePicker
        v-model="range"
        granularity="day"
        :max="parseAbsoluteToLocal(dayjs().utc().format())"
      />
      <!--      <CommandPaletteItem-->
      <!--        :category="$commandPalette.category.Actions"-->
      <!--        :text="__('Save')"-->
      <!--        icon="save"-->
      <!--        :action="save"-->
      <!--        prioritize-->
      <!--        v-slot="{ text, action }"-->
      <!--      >-->
      <!--        <Button-->
      <!--          type="submit"-->
      <!--          variant="primary"-->
      <!--          @click="action"-->
      <!--        >{{ text }}-->
      <!--        </Button>-->
      <!--      </CommandPaletteItem>-->
    </Header>

    <div class="grid grid-cols-1 gap-6">
      <template v-for="chart in charts">

        <component
          v-if="components[chart] != null"
          :is="components[chart]"
          v-bind="{...range, url: props.url, propertyId: props.propertyId }"
        />
      </template>
    </div>
  </div>
</template>

<style scoped>

</style>