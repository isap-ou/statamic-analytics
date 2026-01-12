/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */
import { onMounted, ref, toRef, watch } from "vue";

/**
 * useFetch composable for fetching data with reactive props.
 * @param {string} endpoint - The endpoint to append to the url.
 * @param {object} props - An object with keys: start, end, url, propertyId.
 * @returns {object} { request, loading, data }
 */
export function useFetch(endpoint, props) {
  const { $axios } = Statamic.$app.config.globalProperties;
  const loading = ref(true);
  const data = ref([]);

  // Keep reactivity even if the caller destructures props.
  const start = toRef(props, "start");
  const end = toRef(props, "end");
  const url = toRef(props, "url");
  const propertyId = toRef(props, "propertyId");

  function request() {
    data.value = [];
    loading.value = true;

    const startDate =
      start.value.year + "-" + start.value.month + "-" + start.value.day;
    const endDate =
      end.value.year + "-" + end.value.month + "-" + end.value.day;

    $axios
      .get(url.value + "/" + endpoint, {
        params: {
          property_id: propertyId.value,
          start: startDate,
          end: endDate,
        },
      })
      .then((response) => {
        data.value = response.data;
      })
      .finally(() => (loading.value = false));
  }

  // Re-fetch when date range changes.
  watch(start, (value, oldValue) => {
    request();
  });
  watch(end, (value, oldValue) => {
    request();
  });

  onMounted(() => request());

  function ensureSchema(url) {
    if (!url) return url;

    if (/^[a-z]+:\/\//i.test(url)) {
      return url;
    }

    return `https://${url}`;
  }

  return { request, loading, data, ensureSchema };
}

export const widgetProps = {
  start: Object,
  end: Object,
  url: String,
  propertyId: [String, Number],
};
