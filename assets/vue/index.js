import Vue from 'vue';
import App from './App.vue';

import 'material-icons/iconfont/material-icons.css';

import axios from 'axios';

const base = axios.create({baseURL: 'http://localhost:8000'});

Vue.prototype.$http = base;

// Vue Router
import router from './router';

Vue.config.productionTip = false;

new Vue({
  router,
  render: h => h(App)
}).$mount('#app');
