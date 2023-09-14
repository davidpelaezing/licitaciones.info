import axios from 'axios';
import VueAxios from 'vue-axios'
import Vue from 'vue';
import App from './App.vue';
import router from './router.js';
import Snotify, { SnotifyPosition } from 'vue-snotify';
import 'bootstrap/dist/css/bootstrap.css'
import 'vue-snotify/styles/material.css';


Vue.component('pagination', require('laravel-vue-pagination'));

axios.defaults.baseURL = '/api';
axios.interceptors.request.use(
  (config) => {
    config.headers['Content-Type'] = 'application/json'
    config.headers['Accept']= 'application/json'

    // Recupera el token de autorización del Local Storage
    const token = localStorage.getItem("token");
    // Si existe un token, agrégalo al encabezado de autorización
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
);

const options = {
  toast: {
    position: SnotifyPosition.rightTop,
    timeout: 6000,
  }
};

Vue.use(VueAxios, axios);
Vue.use(Snotify, options);

new Vue({
  el: '#app',
  router,
  render: (h) => h(App),
});