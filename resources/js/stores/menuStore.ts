import { defineStore } from 'pinia'
import axios from "axios";
import { MenuItemType, StaticMenuItemType, MenuResponseType } from '@/types/menu'

export const useMenuStore = defineStore('menus', {
    state: () => ({
        menus: [] as MenuItemType[],
        isLoading: false,
        staticMenu: [
            { title: 'Головна', link: '/' },
            { title: 'Виховна робота', link: '/struktura-vixovnoyi-roboti' },
            { title: 'Оголошення', link: '/news' },
            { title: 'Фотогалерея', link: '/gallery' },
            { title: 'Контакти', link: '/contacts' }
        ] as StaticMenuItemType[]
    }),

    getters: {},

    actions: {
        async getMenus() {
            this.isLoading = true;
            try {
                const res = await axios.get<MenuResponseType>('/api/menu');
                this.menus = res.data.data
            } catch (error) {
                console.error('Помилка завантаження меню:', error);
            } finally {
                this.isLoading = false;
            }

        }
    },
})

