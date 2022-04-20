require('./bootstrap');

import VueRouter from 'vue-router';
import LedgerIndexComponent from "./pages/ledger/IndexComponent";
import NotFoundComponent from "./pages/utility/NotFoundComponent";

window.Vue = require('vue').default;
Vue.use(VueRouter);

const router = new VueRouter({
     mode: 'history',
     routes: [
        {
            path: '/',
            component: LedgerIndexComponent
        },
        {
             path: '/home',
             component: LedgerIndexComponent
        },
        {
            path: '/ledgers',
            name: 'ledgers.index',
            component: LedgerIndexComponent
        },
        {
            path: '*',
            name: '404',
            component: NotFoundComponent
        },
     ]
});

const app = new Vue({
    el: '#app',
    router
});
