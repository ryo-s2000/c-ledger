require('./bootstrap');

import VueRouter from 'vue-router';
import ConstructionIndexPage from "@/pages/construction/IndexPage";
import ConstructionCreateAndEditPage from "@/pages/construction/CreateAndEditPage";
import NotFoundPage from "@/pages/utility/NotFoundPage";

window.Vue = require('vue').default;
Vue.use(VueRouter);

const router = new VueRouter({
     mode: 'history',
     routes: [
        {
            path: '/',
            name: 'top',
            component: ConstructionIndexPage
        },
        {
            path: '/constructions',
            name: 'constructions.index',
            component: ConstructionIndexPage
        },
        {
            path: '/constructions/create',
            name: 'constructions.create',
            component: ConstructionCreateAndEditPage
        },
        {
            path: '/constructions/:id/copy/create',
            name: 'constructions.copy.create',
            component: ConstructionCreateAndEditPage
        },
        {
            path: '/constructions/:id/edit',
            name: 'constructions.edit',
            component: ConstructionCreateAndEditPage
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
