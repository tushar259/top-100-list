import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import $ from 'jquery';
import {router} from './router.js';
// import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
// import 'bootstrap-vue/dist/bootstrap-vue.css';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
// import { createMetaManager } from 'vue-meta';

const app = createApp(App);
app.use(router);
// app.use(moment);
app.use(Toast);
// app.use(createMetaManager());
app.use($);
app.mount('#app');
