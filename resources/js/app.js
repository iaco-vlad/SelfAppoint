import './bootstrap';

import {createApp} from 'vue';

import App from './App.vue';

import Router from './routes/main';

createApp(App).use(Router).mount("#app");
