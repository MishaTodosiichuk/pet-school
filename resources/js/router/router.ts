import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/pages/home/index.vue')
    },
    {
        path: '/news',
        name: 'news',
        component: () => import('@/pages/news/index.vue')
    },
    {
        path: '/news/:slug',
        name: 'news-show',
        component: () => import('@/pages/news/show.vue')
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        return {
            top: 0,
            left: 0,
            behavior: 'smooth'
        };
    }
});

export default router;
