import axios from 'axios'
import type { AxiosResponse } from 'axios'
import type {GalleryResponseType} from "../types";

export const apiGallery = {
    fetchGallery(endpoint: 'main-gallery' | 'page-gallery'): Promise<AxiosResponse<GalleryResponseType>> {
        return axios.get<GalleryResponseType>(`/api/${endpoint}`)
    },
}
