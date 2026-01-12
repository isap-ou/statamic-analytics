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
import { Header, Icon } from "@statamic/cms/ui";

defineProps({
  header: { type: String, default: null },
  loading: {
    type: Boolean,
    default: false,
  },
  noData: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <div>
    <Header :title="__('isapp-analytics::cp.' + header)" class="pb-6!" />

    <div v-if="loading" class="loading flex h-full items-center justify-center">
      <Icon name="loading" />
    </div>
    <template v-if="!loading && !noData">
      <slot />
    </template>
    <template v-else-if="!loading && noData">
      <div
        class="p-4 text-gray-700 text-sm text-center"
        v-text="__('No results')"
      />
    </template>
  </div>
</template>

<style scoped></style>
