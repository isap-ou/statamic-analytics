import GoogleAnalytics from "./components/GoogleAnalytics.vue";
import {Line, Bar} from "vue-chartjs/legacy";

Statamic.booting(() => {
    Statamic.$components.register("isapp-google-analytics", GoogleAnalytics);
    Statamic.$components.register("chart-line", Line);
    Statamic.$components.register("chart-bar", Bar);
});