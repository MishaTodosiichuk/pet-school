import { defineStore } from 'pinia'
import axios from "axios";

import { ImageItemType, ImageResponseType } from '@/types/image'

export const useImageStore = defineStore('image', {
    state: () => ({
        images: [] as ImageItemType[],
        randomImages: [] as ImageItemType[],
        isLoading: false
    }),

    getters: {},

    actions: {
        async getRandomImages() {
            this.isLoading = true
            try {
                const res = await axios.get<ImageResponseType>('/api/random-images');
                this.randomImages = res.data.data
            } catch (error) {
                console.error('Помилка завантаження зображень:', error);
            } finally {
                this.isLoading = false
            }
        }
    }
});
