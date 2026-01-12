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
  Button,
  CommandPaletteItem,
  Header,
  PublishContainer,
} from "@statamic/cms/ui";
import { computed, onMounted, onUnmounted, ref, useTemplateRef } from "vue";
import { Pipeline, Request } from "@statamic/cms/save-pipeline";

const props = defineProps({
  blueprint: { type: Object, default: () => ({}) },
  initialValues: { type: Object, default: () => ({}) },
  meta: { type: Object, default: () => ({}) },
  url: { type: String, default: null },
});

const container = useTemplateRef("container");
const values = ref(props.initialValues);
const errors = ref({});
const saving = ref(false);

const pageTitle = computed(() =>
  Statamic.$config.get("multisiteEnabled")
    ? __("Configure Sites")
    : __("Configure Analytics"),
);

const initialSiteHandles = computed(() => {
  return Statamic.$config.get("multisiteEnabled")
    ? props.initialValues.sites.map((site) => site.handle)
    : [props.initialValues.handle];
});

const currentSiteHandles = computed(() => {
  return Statamic.$config.get("multisiteEnabled")
    ? values.value.sites.map((site) => site.handle)
    : [values.value.handle];
});

const initialHandleChanged = computed(
  () =>
    initialSiteHandles.value.filter(
      (handle) => !currentSiteHandles.value.includes(handle),
    ).length > 0,
);
const initialHandleChangedWarning = computed(() =>
  __("Warning! Changing a site handle may break existing site content!"),
);

function save() {
  if (
    initialHandleChanged.value &&
    !confirm(initialHandleChangedWarning.value)
  ) {
    return;
  }

  new Pipeline()
    .provide({ container, errors, saving })
    .through([new Request(props.url, "patch")])
    .then((response) => {
      Statamic.$toast.success(__("Saved"));

      if (Statamic.$config.get("multisiteEnabled")) {
        window.location.reload();
      }
    });
}

let saveKeyBinding;

onMounted(() => {
  saveKeyBinding = Statamic.$keys.bindGlobal(["mod+s"], (e) => {
    e.preventDefault();
    save();
  });
});

onUnmounted(() => saveKeyBinding.destroy());
</script>
<template>
  <div class="max-w-5xl mx-auto">
    <Header :title="pageTitle" icon="site">
      <CommandPaletteItem
        v-slot="{ text, action }"
        :category="$commandPalette.category.Actions"
        :text="__('Save')"
        icon="save"
        :action="save"
        prioritize
      >
        <Button type="submit" variant="primary" @click="action">
          {{ text }}
        </Button>
      </CommandPaletteItem>
    </Header>

    <PublishContainer
      v-if="blueprint"
      ref="container"
      v-model="values"
      name="sites"
      reference="sites"
      :blueprint
      :meta
      :errors
    />
  </div>
</template>
