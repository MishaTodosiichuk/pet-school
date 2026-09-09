import type { RouteRecordRaw } from 'vue-router'

export const newsRoutes: RouteRecordRaw[] = [
    {
        path: '/news',
        name: 'news',
        component: () => import('@/pages/news/index.vue')
    },
    {
        path: '/news/:slug',
        name: 'news-show',
        component: () => import('@/pages/news/show.vue')
    }
]
