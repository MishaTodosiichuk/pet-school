
import {LinksType, MetaType} from "@/modules/app/types/pagination";
import {ImageType} from "@/modules/image/types";

interface BaseItem {
    title: string
    description: string
    slug: string
    viewsCount: number
    published: string
    image: ImageType
}

export interface NewsType extends BaseItem {}

export interface ItemShowType extends BaseItem {
    images: ImageType[]
}
export interface ResponseType {
    links: LinksType,
    meta: MetaType,
    data: NewsType[]
}

export interface SingleResponseType {
    data: ItemShowType
}
