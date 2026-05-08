import { defineStore } from 'pinia'
import axios from 'axios'
import { loading } from '@/loading'

import {NewsItemType, NewsItemShowType, NewsResponseType, SingleNewsResponseType} from '@/types/news'
import {LinksItemType, MetaItemType} from "@/types/pagination";

export const useNewsStore = defineStore('news', {
    state: () => ({
        news: [] as NewsItemType[],
        singleNews: null as NewsItemShowType | null,
        allNews: [] as NewsItemType[],
        filters: {
            dates: null as string[] | null
        },
        links: null as LinksItemType | null,
        meta: null as MetaItemType | null,
    }),

    actions: {
        async getNews() {
            await loading.show()

            try {
                const res = await axios.get<NewsResponseType>('/api/news')
                this.news = res.data.data
            } catch (error) {
                console.error('Помилка завантаження новин:', error)
            } finally {
                loading.hide()
            }
        },

        async getNewsBySlug(slug: string) {
            await loading.show()

            try {
                const res = await axios.get<SingleNewsResponseType>(`/api/news-show-single/${slug}`)
                this.singleNews = res.data.data
            } catch (error) {
                console.error('Помилка завантаження новини:', error)
            } finally {
                loading.hide()
            }
        },

        async getNewsAll(
            page = 1,
            append = false,
            dates: string[] | null | undefined = undefined
        ) {
            await loading.show()

            if (dates !== undefined) {
                this.filters.dates = dates
            }

            const params: Record<string, any> = { page }

            if (this.filters.dates?.length === 2) {
                params['start-date'] = this.filters.dates[0]
                params['end-date'] = this.filters.dates[1]
            }

            try {
                const res = await axios.get<NewsResponseType>('/api/news-all-data', { params })

                if (append) {
                    this.allNews = [...this.allNews, ...res.data.data]
                } else {
                    this.allNews = res.data.data
                }

                this.links = res.data.links
                this.meta = res.data.meta
            } catch (error) {
                console.error('Помилка фільтрації:', error)
            } finally {
                loading.hide()
            }
        },

        async incrementViews (slug: string) {
            try {
                await axios.post(`/api/news/${slug}/views`)
            } catch (e) {
            }
        }
    }
})
