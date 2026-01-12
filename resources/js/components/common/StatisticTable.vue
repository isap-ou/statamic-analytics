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
import {
  Listing,
  ListingSearch,
  ListingTable,
  Pagination,
  Panel,
  PanelFooter,
} from "@statamic/cms/ui";
import { computed, nextTick, onMounted, ref, useSlots } from "vue";
import { orderBy } from "lodash-es";

const slots = useSlots();
const props = defineProps({
  columns: { type: Array, default: () => [] },
  data: { type: Array, default: () => [] },
  sortColumn: { type: String, default: null },
  sortDirection: { type: String, default: null },
  noPagination: {
    type: Boolean,
    default: false,
  },
  showPerPageSelector: {
    type: Boolean,
    default: true,
  },
});

const currentPage = ref(1);
const perPage = ref(10);
const sortableColumn = ref(props.sortColumn);
const sortableColumnDirection = ref(props.sortDirection);
const items = ref([]);

function setCurrentPage(page) {
  currentPage.value =
    Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
  nextTick(() => processItems());
}

function setPerPage(page) {
  perPage.value = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
  nextTick(() => processItems());
}

function setSortColumn(sortColumn) {
  sortableColumn.value = sortColumn;
  nextTick(() => processItems());
}

function setSortDirection(sortDirection) {
  sortableColumnDirection.value = sortDirection;
  nextTick(() => processItems());
}

function ensureSchema(url) {
  if (!url) return url;

  if (/^[a-z]+:\/\//i.test(url)) {
    return url;
  }

  return `https://${url}`;
}

onMounted(() => processItems());

const total = computed(
  () => (Array.isArray(props.data) ? props.data : []).length,
);
const processItems = () => {
  const list = Array.isArray(props.data) ? props.data : [];
  let page = currentPage.value;
  let perPageValue = perPage?.value;

  // normalize
  page = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
  perPageValue =
    Number.isFinite(+perPageValue) && +perPageValue > 0
      ? Math.floor(+perPageValue)
      : 10;

  const lastPage = Math.max(1, Math.ceil(total.value / perPageValue));
  page = Math.min(page, lastPage);

  // Keep mixin state in sync (useful if caller passes options.page/options.perPageValue)
  currentPage.value = page;
  perPage.value = perPageValue;
  const start = (page - 1) * perPageValue;

  items.value = orderBy(
    list,
    [sortableColumn.value],
    [sortableColumnDirection.value],
  ).slice(start, start + perPageValue);
};
const meta = computed(() => {
  let page = currentPage.value;
  let perPageValue = perPage?.value;
  console.log(total);
  // normalize
  page = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
  perPageValue =
    Number.isFinite(+perPageValue) && +perPageValue > 0
      ? Math.floor(+perPageValue)
      : 15;

  const lastPage = Math.max(1, Math.ceil(total.value / perPageValue));
  page = Math.min(page, lastPage);

  const from = total.value === 0 ? null : (page - 1) * perPageValue + 1;
  const to =
    total.value === 0 ? null : Math.min(page * perPageValue, total.value);

  return {
    current_page: page,
    from,
    to,
    last_page: lastPage,
    per_page: perPageValue,
    total: total.value,
  };
});

const forwardedTableCellSlots = computed(() => {
  return Object.keys(slots)
    .filter((slotName) => slotName.startsWith("cell-"))
    .reduce((acc, slotName) => {
      acc[slotName] = slots[slotName];
      return acc;
    }, {});
});
</script>

<template>
  <Listing
    :columns="columns"
    :items="items"
    :meta="meta"
    :per-page="perPage"
    :show-pagination-totals="true"
    :show-pagination-page-links="true"
    :sort-column="sortableColumn"
    :sort-direction="sortableColumnDirection"
    :allow-customizing-columns="false"
    :allow-search="false"
    @update:sort-column="setSortColumn"
    @update:sort-direction="setSortDirection"
  >
    <template #default>
      <Panel
        class="relative overflow-x-auto overscroll-x-contain"
        style="container-type: scroll-state"
      >
        <div
          v-if="items.length > 10"
          class="relative overflow-clip flex items-center gap-2 sm:gap-3 min-h-16 starting-style-transition starting-style-transition--siblings"
        >
          <ListingSearch class="max-w-full!" />
        </div>
        <ListingTable :columns="columns" :items="items">
          <template
            v-for="(slot, slotName) in forwardedTableCellSlots"
            :key="slotName"
            #[slotName]="slotProps"
          >
            <component :is="slot" v-bind="slotProps" />
          </template>
          <template
            v-if="$slots['prepended-row-actions']"
            #prepended-row-actions="{ row }"
          >
            <slot name="prepended-row-actions" :row="row" />
          </template>
        </ListingTable>
        <PanelFooter v-if="!noPagination || meta.total <= 10">
          <Pagination
            :per-page="perPage"
            :resource-meta="meta"
            show-totals
            show-page-links
            :show-per-page-selector
            @page-selected="setCurrentPage"
            @per-page-changed="setPerPage"
          />
        </PanelFooter>
      </Panel>
    </template>
  </Listing>
</template>
