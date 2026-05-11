import { defineStore } from 'pinia'
import axios from "axios";

import { GalleryItemType, GalleryResponseType} from '@/types/gallery'

export const useGalleryStore = defineStore('gallery', {
    state: () => ({
        mainGallery: null as GalleryItemType | null,
        pageGallery: null as GalleryItemType | null,
        isLoading: false
    }),

    getters: {},

    actions: {
        async fetchGallery(endpoint: 'main-gallery' | 'page-gallery', target: 'mainGallery' | 'pageGallery') {
            this.isLoading = true
            try {
                const { data } = await axios.get<GalleryResponseType>(`/api/${endpoint}`)
                this[target] = data.data
            } catch (error) {
                console.error(`Помилка завантаження ${endpoint}:`, error)
            } finally {
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
