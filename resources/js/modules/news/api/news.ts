import axios from 'axios'
import type {AxiosResponse} from 'axios'

import type {ResponseType, SingleResponseType,} from '../types'

interface FiltersType {
    page?: number
    startDate?: string
    endDate?: string
}

export const apiNews = {
    getNews(filters?: FiltersType) {
        return axios.get<ResponseType>('/api/news', {
            params: {
                page: filters?.page,
                'start-date': filters?.startDate,
                'end-date': filters?.endDate,
            },
        })
    },

    getNewsBySlug(
        slug: string
    ): Promise<AxiosResponse<SingleResponseType>> {
        return axios.get<SingleResponseType>(
            `/api/news-show-single/${slug}`,
        )
    },

    incrementViews(slug: string) {
        return axios.post(`/api/news/${slug}/views`)
    },
}
