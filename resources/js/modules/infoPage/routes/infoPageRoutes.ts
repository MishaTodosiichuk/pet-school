import type { RouteRecordRaw } from 'vue-router'

export const infoPageRoutes: RouteRecordRaw[] = [
    {
        path: '/page/:slug',
        name: 'page',
        component: () => import('@/pages/page-info/show.vue')
    },
]
