import { defineStore } from 'pinia'
import axios from "axios";

import { ImageItem, ImageResponse } from '@/types/image'

export const useImageStore = defineStore('image', {
    state: () => ({
        images: [] as ImageItem[],
        randomImages: [] as ImageItem[],
        isLoading: false
    }),

    getters: {},

    actions: {
        async getRandomImages() {
            this.isLoading = true
            try {
                const res = await axios.get<ImageResponse>('/api/random-images');
                this.randomImages = res.data.data
            } catch (error) {
                console.error('Помилка завантаження зображень:', error);
            } finally {
                this.isLoading = false
            }
        }
    }
});
