import {PageInfoResponseType, PageInfoType} from "@/modules/infoPage/types/pageInfo";

export interface MenuType {
    title: string,
    slug: string,
    children?: MenuType[]
}
export interface StaticMenuType {
    title: string,
    link: string,
}

export interface MenuPageInfoType {
    title: string,
    page: PageInfoType | null
}

export interface MenuResponseType {
    data: MenuType[];
}
export interface MenuPageInfoResponseType {
    title: string
    page: PageInfoResponseType | null;
}
