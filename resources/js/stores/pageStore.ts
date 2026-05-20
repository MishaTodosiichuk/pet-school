import {defineStore} from 'pinia'
import {loading} from '@/utils/loading'

import axios from "axios";

import {MenuPageInfoResponseType, MenuPageInfoType} from "@/types/menu";

export const usePageStore = defineStore('page', {
    state: () => ({
        pageInfo: {} as MenuPageInfoType | null,
    }),

    getters: {},

    actions: {
        async getPageData (slug: string) {
            await loading.show()
            try {
                const res = await axios.get<MenuPageInfoResponseType>(`/api/page-info-by-slug/${slug}`);
                this.pageInfo = res.data
            } catch (error) {
                console.error('Помилка завантаження даних:', error);
            } finally {
                loading.hide()
            }
        }
    }
})
