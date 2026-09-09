import {defineStore} from 'pinia'
import { useLoading } from '@/modules/app/composables/useLoading'

const {showLoading, hideLoading} = useLoading()

import {MenuPageInfoType} from "@/modules/menu/types/menu";
import {apiInfoPage} from "@/modules/infoPage/api";

export const usePageStore = defineStore('page', {
    state: () => ({
        pageInfo: {} as MenuPageInfoType | null,
    }),

    getters: {},

    actions: {
        async getPageData (slug: string) {
            await showLoading()
            try {
                const res = await apiInfoPage.getPageData(slug)
                this.pageInfo = res.data
            } catch (error) {
                console.error('Помилка завантаження даних:', error);
            } finally {
                hideLoading()
            }
        }
    }
})
