import { defineStore } from 'pinia'
import axios from "axios";

import { NewsItem,  NewsResponse } from '@/types/news'

export const useNewsStore = defineStore('news', {
    state: () => ({
        news: [] as NewsItem[],
        isLoading: false
    }),

    getters: {},

    actions: {
        async getNews() {
            this.isLoading = true
            try {
                const res = await axios.get<NewsResponse>('/api/news');
                this.news = res.data.data
            } catch (error) {
                console.error('Помилка завантаження новин:', error);
            } finally {
                this.isLoading = false
            }
        }
    }
});
