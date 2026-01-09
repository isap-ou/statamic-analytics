<script>
export default {
  props: {
    header: String,
    loading: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<template>
  <div class="card card-lg p-0 content">
    <header>
      <h3 v-text="__('isapp-analytics::cp.' + header)"></h3>
    </header>
    <div v-if="!loading">
      <slot/>
    </div>
    <div
      v-else-if="loading"
      class="loading"
    >
      <loading-graphic/>
    </div>
  </div>
</template>

<style scoped>

</style>