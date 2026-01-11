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
export default {
  props: {
    header: String,
    loading: {
      type: Boolean,
      default: false
    },
    noData: {
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
    <div v-if="!loading && !noData">
      <slot/>
    </div>
    <div
      v-else-if="!loading && noData"
      class="p-4 text-gray-700 text-sm text-center"
      v-text="__('No results')"
    />
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