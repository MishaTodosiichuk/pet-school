import { defineStore } from 'pinia'
import axios from "axios";

import { GalleryItem,  GalleryResponse } from '@/types/gallery'

export const useGalleryStore = defineStore('gallery', {
    state: () => ({
        mainGallery: null as GalleryItem | null,
        isLoading: false
    }),

    getters: {},

    actions: {
        async getMainGallery() {
            this.isLoading = true
            try {
                const res = await axios.get<GalleryResponse>('/api/main-gallery');
                this.mainGallery = res.data.data
            } catch (error) {
                console.error('Помилка завантаження головної галереї:', error);
            } finally {
                this.isLoading = false
            }
        }
    }
});
