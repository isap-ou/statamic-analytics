import {orderBy} from "lodash-es";

export default {
    data() {
        return {
            currentPage: 1,
            perPage: 10,
            sortColumn: null,
            sortDirection: 'asc',
        };
    },

    computed: {
        meta() {
            const list = Array.isArray(this.data) ? this.data : [];
            let page = this.currentPage;
            let perPage = this.perPage;

            const total = list.length;

            // normalize
            page = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
            perPage = Number.isFinite(+perPage) && +perPage > 0 ? Math.floor(+perPage) : 15;

            const lastPage = Math.max(1, Math.ceil(total / perPage));
            page = Math.min(page, lastPage);

            // Keep mixin state in sync (useful if caller passes options.page/options.perPage)
            this.currentPage = page;
            this.perPage = perPage;

            const from = total === 0 ? null : (page - 1) * perPage + 1;
            const to = total === 0 ? null : Math.min(page * perPage, total);

            const start = (page - 1) * perPage;

            return {
                current_page: page,
                from,
                last_page: lastPage,
                per_page: perPage,
                to,
                total,
            };
        },
        items() {
            const list = Array.isArray(this.data) ? this.data : [];
            let page = this.currentPage;
            let perPage = this.perPage;

            const total = list.length;

            // normalize
            page = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
            perPage = Number.isFinite(+perPage) && +perPage > 0 ? Math.floor(+perPage) : 10;

            const lastPage = Math.max(1, Math.ceil(total / perPage));
            page = Math.min(page, lastPage);

            // Keep mixin state in sync (useful if caller passes options.page/options.perPage)
            this.currentPage = page;
            this.perPage = perPage;
            const start = (page - 1) * perPage;
            return orderBy(list, [this.sortColumn], [this.sortDirection]).slice(start, start + perPage);

        },
    },
    methods: {
        setPage(page) {
            this.currentPage = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
        },
        setPerPage(page) {
            this.perPage = Number.isFinite(+page) && +page > 0 ? Math.floor(+page) : 1;
        },
        sorted(sortColumn, sortDirection) {
            this.sortColumn = sortColumn;
            this.sortDirection = sortDirection;
        },

        ensureSchema(url) {
            if (!url) return url;

            if (/^[a-z]+:\/\//i.test(url)) {
                return url;
            }

            return `https://${url}`;
        }
    },


};