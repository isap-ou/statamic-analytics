<script>
import pagination from "../../mixins/pagination";

export default {
  name: "Table",
  mixins: [pagination],
  props: {
    columns: Array,
    data: Array,
    sortColumn: String,
    sortDirection: String,
    noPagination: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<template>
  <data-list
    :columns="columns"
    :rows="items"
    :sort-column="sortColumn"
    :sort-direction="sortDirection"
  >
    <div
      class="p-0"
      slot-scope="{ filteredRows: rows }"
    >
      <data-list-table
        @sorted="sorted"
      >
        <!-- Forward all scoped slots (e.g. cell-*) to the inner data-list-table -->
        <template
          v-for="(slotFn, name) in $scopedSlots"
          v-slot:[name]="slotProps"
        >
          <slot
            :name="name"
            v-bind="slotProps"
          />
        </template>
      </data-list-table>


      <data-list-pagination
        v-if="!noPagination"
        class="py-2 px-4 border-t bg-gray-200 rounded-b-lg text-sm dark:bg-dark-650 dark:border-gray-900"
        :resource-meta="meta"
        :per-page="perPage"
        show-totals
        show-page-links
        :scroll-to-top="false"
        @per-page-changed="setPerPage"
        @page-selected="setPage"
      />
    </div>
  </data-list>
</template>

<style scoped>

</style>