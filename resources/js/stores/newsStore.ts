import { defineStore } from 'pinia'
import axios from 'axios'
import {loading} from '@/utils/loading'

import {NewsItemType, NewsItemShowType, NewsResponseType, SingleNewsResponseType} from '@/types/news'
import {LinksItemType, MetaItemType} from "@/types/pagination";

export const useNewsStore = defineStore('news', {
    state: () => ({
        news: [] as NewsItemType[] | null,
        singleNews: null as NewsItemShowType | null,
        allNews: [] as NewsItemType[],
        filters: {
            dates: null as string[] | null
        },
        links: null as LinksItemType | null,
        meta: null as MetaItemType | null,
    }),

    actions: {
        async _wrapRequest<T>(request: Promise<{ data: { data: T } }>, errorMsg: string): Promise<T | null> {
            await loading.show();
            try {
                const res = await request;
                return res.data.data;
            } catch (error) {
                console.error(errorMsg, error);
                return null;
            } finally {
                loading.hide();
            }
        },

        async getNewsAll(page = 1, append = false, dates?: string[] | null) {
            if (dates !== undefined) this.filters.dates = dates;

            const params: Record<string, any> = { page };
            if (this.filters.dates?.length === 2) {
                params['start-date'] = this.filters.dates[0];
                params['end-date'] = this.filters.dates[1];
            }

            await loading.show();
            try {
                const res = await axios.get<NewsResponseType>('/api/news-all-data', { params });

                this.allNews = append ? [...this.allNews, ...res.data.data] : res.data.data;
                this.links = res.data.links;
                this.meta = res.data.meta;

                if (page === 1 && !dates) this.news = res.data.data;

            } catch (error) {
                console.error('Помилка завантаження списку новин:', error);
            } finally {
                loading.hide();
            }
        },

        async getNews() {
            const data = await this._wrapRequest<NewsResponseType['data']>(
                axios.get(`/api/news`),
                'Помилка завантаження новин'
            );
            if (data) this.news = data;
        },

        async getNewsBySlug(slug: string) {
            const data = await this._wrapRequest<SingleNewsResponseType['data']>(
                axios.get(`/api/news-show-single/${slug}`),
                'Помилка завантаження новини'
            );
            if (data) this.singleNews = data;
        },

        async incrementViews(slug: string) {
            axios.post(`/api/news/${slug}/views`).catch(() => {});
        }
    }
})
