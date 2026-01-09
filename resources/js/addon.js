import GoogleAnalytics from "./components/GoogleAnalytics.vue";
import ConfigForm from "./components/ConfigForm.vue";
import {Line, Bar, Pie} from "vue-chartjs/legacy";

Statamic.booting(() => {
    Statamic.$components.register("isapp-analytics", GoogleAnalytics);
    Statamic.$components.register("isapp-analytics-settings", ConfigForm);
    Statamic.$components.register("chart-line", Line);
    Statamic.$components.register("chart-bar", Bar);
    Statamic.$components.register("chart-pie", Pie);
});