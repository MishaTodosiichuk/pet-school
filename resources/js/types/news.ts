import { ImageItemType } from './image'
import {LinksItemType, MetaItemType} from "@/types/pagination";

interface BaseNewsItem {
    title: string
    description: string
    slug: string
    viewsCount: number
    published: string
    image: ImageItemType
}

export interface NewsItemType extends BaseNewsItem {}

export interface NewsItemShowType extends BaseNewsItem {
    images: ImageItemType[]
}
export interface NewsResponseType {
    links: LinksItemType,
    meta: MetaItemType,
    data: NewsItemType[]
}

export interface SingleNewsResponseType {
    data: NewsItemShowType
}
