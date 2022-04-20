require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import HomeComponent from "./pages/home/HomeComponent";

Vue.use(VueRouter);

const router = new VueRouter({
     mode: 'history',
     routes: [
         {
             path: '/home',
             name: 'home',
             component: HomeComponent
         },
     ]
});

const app = new Vue({
    el: '#app',
    router
});
