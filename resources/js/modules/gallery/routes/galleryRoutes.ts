import type { RouteRecordRaw } from 'vue-router'

export const galleryRoutes: RouteRecordRaw[] = [
    {
        path: '/gallery',
        name: 'gallery',
        component: () => import('@/pages/gallery/index.vue')
    },
]
