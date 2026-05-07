import { defineStore } from 'pinia'
import axios from "axios";
import { MenuItem, StaticMenuItem, MenuResponse } from '@/types/menu'

export const useMenuStore = defineStore('menus', {
    state: () => ({
        menus: [] as MenuItem[],
        isLoading: false,
        staticMenu: [
            { title: 'Головна', link: '/' },
            { title: 'Виховна робота', link: '/struktura-vixovnoyi-roboti' },
            { title: 'Оголошення', link: '/ogolosennia' },
            { title: 'Фотогалерея', link: '/gallery' },
            { title: 'Контакти', link: '/contacts' }
        ] as StaticMenuItem[]
    }),

    getters: {},

    actions: {
        async getMenus() {
            this.isLoading = true;
            try {
                const res = await axios.get<MenuResponse>('/api/menu');
                this.menus = res.data.data
            } catch (error) {
                console.error('Помилка завантаження меню:', error);
            } finally {
                this.isLoading = false;
            }

        }
    },
})

