import { createRouter, createWebHashHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import(/* webpackChunkName: "test" */ '../../components/pages/Home.vue'),
        meta: {
            order: 0,
        }
    },
    {
        path: '/register',
        name: '[IF] Register User',
        component: () => import(/* webpackChunkName: "test1" */ '../../components/pages/Test1.vue'),
        meta: {
            order: 1,
        }
    },
    {
        path: '/login',
        name: '[IF] User Login',
        component: () => import(/* webpackChunkName: "test2" */ '../../components/pages/Test2.vue'),
        meta: {
            order: 1,
        }
    },
    {
        path: '/users',
        name: '[AF] User List',
        component: () => import(/* webpackChunkName: "test2" */ '../../components/pages/Test3.vue'),
        meta: {
            order: 1,
        }
    },
     {
        path: '/users/edit/:id',
        name: '[IF] User Edit',
        component: () => import(/* webpackChunkName: "test2" */ '../../components/pages/Test4.vue'),
        meta: {
            order: 1,
        }
    },
    {
        path: '/rest-data',
        name: '[AF] Reset Data',
        component: () => import(/* webpackChunkName: "test2" */ '../../components/pages/Test5.vue'),
        meta: {
            order: 1,
        }
    },
]
const router = createRouter({
    history: createWebHashHistory(),
    routes
})
export default router
