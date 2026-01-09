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
