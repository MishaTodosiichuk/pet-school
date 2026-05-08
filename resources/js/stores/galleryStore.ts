import { defineStore } from 'pinia'
import axios from "axios";

import { GalleryItemType, GalleryResponseType} from '@/types/gallery'

export const useGalleryStore = defineStore('gallery', {
    state: () => ({
        mainGallery: null as GalleryItemType | null,
        isLoading: false
    }),

    getters: {},

    actions: {
        async getMainGallery() {
            this.isLoading = true
            try {
                const res = await axios.get<GalleryResponseType>('/api/main-gallery');
                this.mainGallery = res.data.data
            } catch (error) {
                console.error('Помилка завантаження головної галереї:', error);
            } finally {
                this.isLoading = false
            }
        }
    }
});
