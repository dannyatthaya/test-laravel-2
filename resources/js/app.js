import { createApp } from 'vue';
import Notifications from 'notiwind';

import dialogService from "@/services/dialog.js";
import App from "@/App.vue";

const app = createApp(App);

app.config.globalProperties.$dialog = dialogService;

Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
  app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.use(Notifications)
  .mount('#app');
