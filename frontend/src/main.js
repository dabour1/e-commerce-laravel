import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./routers/index";
import "./style.css";

import App from "./App.vue";

const app = createApp(App);
app.use(router);

const pinia = createPinia();
app.use(pinia);

app.mount("#app");
