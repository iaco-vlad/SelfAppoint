import './bootstrap';

import {createApp} from 'vue';

import App from './App.vue';

import Router from './routes/main';
import Store from './Utils/store';

axios.interceptors.request.use(function (config) {
    const token = Store.getters['token'];
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});


createApp(App).use(Store).use(Router).mount("#app");
