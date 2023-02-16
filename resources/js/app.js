import './bootstrap';

import {createApp} from 'vue';

import App from './App.vue';

import Router from './routes/main';
import Store from './utils/store';

createApp(App).use(Store).use(Router).mount("#app");
