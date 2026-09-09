import {defineStore} from 'pinia'
import {useLoading} from '@/modules/app/composables/useLoading'

const {showLoading, hideLoading} = useLoading()

import {NewsType, ItemShowType} from '@/modules/news/types/news'
import {LinksType, MetaType} from "@/modules/app/types/pagination";

import {apiNews} from "@/modules/news/api";
import {useRequest} from "@/modules/news/composables";

export const useNewsStore = defineStore('news', {
    state: () => ({
        news: [] as NewsType[],
        singleNews: null as ItemShowType | null,
        filters: {
            dates: null as string[] | null
        },
        links: null as LinksType | null,
        meta: null as MetaType | null,
    }),

    actions: {
        async getNews(page = 1, append = false, dates?: string[] | null) {
            if (dates !== undefined) {
                this.filters.dates = dates
            }

            await showLoading()

            try {
                const res = await apiNews.getNews({
                    page,
                    startDate: this.filters.dates?.[0],
                    endDate: this.filters.dates?.[1],
                })

                const data = res.data

                this.news = append
                    ? [...this.news, ...data.data]
                    : data.data

                this.links = data.links
                this.meta = data.meta

                if (page === 1 && !dates) {
                    this.news = data.data
                }
            } catch (error) {
                console.error(
                    'Помилка завантаження списку новин:',
                    error
                )
            } finally {
                hideLoading()
            }
        },

        async getNewsBySlug(slug: string) {
            const data = await useRequest(apiNews.getNewsBySlug(slug))

            if (data) this.singleNews = data;
        },

        async incrementViews(slug: string) {
            await apiNews.incrementViews(slug).catch(() => {})
        }
    }
})
export default useNewsStore
