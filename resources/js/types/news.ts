import { ImageItem } from './image'

export interface NewsItem {
    title: string,
    description: string,
    slug: string,
    viewsCount: number,
    published: string,
    image: ImageItem
}

export interface NewsResponse {
    data: NewsItem[];
}
