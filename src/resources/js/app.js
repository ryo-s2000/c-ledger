require('./bootstrap');

import VueRouter from 'vue-router';
import LedgerIndexPage from "./pages/ledger/IndexPage";
import NotFoundPage from "./pages/utility/NotFoundPage";

window.Vue = require('vue').default;
Vue.use(VueRouter);

const router = new VueRouter({
     mode: 'history',
     routes: [
        {
            path: '/',
            component: LedgerIndexPage
        },
        {
             path: '/home',
             component: LedgerIndexPage
        },
        {
            path: '/ledgers',
            name: 'ledgers.index',
            component: LedgerIndexPage
        },
        {
            path: '*',
            name: '404',
            component: NotFoundPage
        },
     ]
});

const app = new Vue({
    el: '#app',
    router
});
