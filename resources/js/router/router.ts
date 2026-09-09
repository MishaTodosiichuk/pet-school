import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import {appRoutes} from "@/modules/app/routes";
import {newsRoutes} from "@/modules/news/routes";
import {galleryRoutes} from "@/modules/gallery/routes";
import {contactRoutes} from "@/modules/contact/routes";
import {infoPageRoutes} from "@/modules/infoPage/routes";

const routes: RouteRecordRaw[] = [
    ...appRoutes,
    ...newsRoutes,
    ...galleryRoutes,
    ...contactRoutes,
    ...infoPageRoutes,
];

const router = createRouter({
    history: createWebHistory('/'),
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
