import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/cars',
            name: 'cars',
            component: () => import('./views/Car.vue')
        }
    ],
});


export default router
