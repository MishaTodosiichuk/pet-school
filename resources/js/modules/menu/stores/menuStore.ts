import { defineStore } from 'pinia'
import { useLoading } from '@/modules/app/composables/useLoading'
import {MenuType, StaticMenuType} from "@/modules/menu/types";
import {apiMenus} from "@/modules/menu/api";

const {showLoading, hideLoading} = useLoading()

export const useMenuStore = defineStore('menus', {
    state: () => ({
        menus: [] as MenuType[],
        staticMenu: [
            { title: 'Головна', link: '/' },
            { title: 'Оголошення', link: '/news' },
            { title: 'Фотогалерея', link: '/gallery' },
            { title: 'Контакти', link: '/contacts' }
        ] as StaticMenuType[]
    }),

    getters: {},

    actions: {
        async getMenus() {
            await showLoading()
            try {
                const res = await apiMenus.getMenus();
                this.menus = res.data.data
            } catch (error) {
                console.error('Помилка завантаження меню:', error);
            } finally {
                hideLoading()
            }
        }
    },
})

