import axios from 'axios'
import type {AxiosResponse} from 'axios'

import type {ImageResponseType} from '../types'

export const apiImage = {
    getRandomImages(): Promise<AxiosResponse<ImageResponseType>> {
        return axios.get<ImageResponseType>('/api/random-images')
    },
}
