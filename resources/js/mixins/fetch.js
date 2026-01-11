/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */

export default {
    props: {
        start: String,
        end: String,
        url: String,
        propertyId: String
    },

    data() {
        return {
            loading: false,
            data: []
        }
    },

    created() {
        this.fetch()
    },

    watch: {
        start() {
            this.fetch()
        },
        end() {
            this.fetch()
        }
    },
    methods: {
        fetch() {
            this.data = [];
            this.loading = true;
            this.$axios.get(this.url + '/' + this.$options.name, {
                'params': {
                    property_id: this.propertyId,
                    start: this.start,
                    end: this.end
                }
            }).then(response => {
                this.data = response.data;
            }).finally(() => this.loading = false)
        }
    }
}
