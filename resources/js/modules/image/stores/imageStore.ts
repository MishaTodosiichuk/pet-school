import {defineStore} from 'pinia'

import {useLoading} from '@/modules/app/composables/useLoading'
import {ImageType} from "@/modules/image/types";
import {apiImage} from "@/modules/image/api";

const {showLoading, hideLoading} = useLoading()

export const useImageStore = defineStore('image', {
    state: () => ({
        images: [] as ImageType[],
        randomImages: [] as ImageType[],
    }),

    getters: {},

    actions: {
        async getRandomImages() {
            await showLoading()
            try {
                const res = await apiImage.getRandomImages()
                this.randomImages = res.data.data
            } catch (error) {
                console.error('Помилка завантаження зображень:', error);
            } finally {
                hideLoading()
            }
        }
    }
});
