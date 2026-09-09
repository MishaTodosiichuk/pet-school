import { defineStore } from 'pinia'
import { useLoading } from '@/modules/app/composables/useLoading'
import {GalleryType} from "@/modules/gallery/types";
import {apiGallery} from "@/modules/gallery/api";

const {showLoading, hideLoading} = useLoading()

export const useGalleryStore = defineStore('gallery', {
    state: () => ({
        mainGallery: null as GalleryType | null,
        pageGallery: null as GalleryType | null,
        isLoading: false
    }),

    getters: {},

    actions: {
        async fetchGallery(endpoint: 'main-gallery' | 'page-gallery', target: 'mainGallery' | 'pageGallery') {
            this.isLoading = true
            await showLoading()
            try {
                const res = await apiGallery.fetchGallery(endpoint)
                this[target] = res.data.data
            } catch (error) {
                console.error(`Помилка завантаження ${endpoint}:`, error)
            } finally {
                hideLoading()
                this.isLoading = false
            }
        },

        async getMainGallery() {
            await this.fetchGallery('main-gallery', 'mainGallery')
        },

        async getPageGallery() {
            await this.fetchGallery('page-gallery', 'pageGallery')
        }
    }
});
