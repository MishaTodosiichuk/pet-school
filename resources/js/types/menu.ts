import {PageInfoResponseType, PageInfoType} from "@/types/pageInfo";

export interface MenuItemType {
    title: string,
    slug: string,
    children?: MenuItemType[]
}
export interface StaticMenuItemType {
    title: string,
    link: string,
}

export interface MenuPageInfoType {
    title: string,
    page: PageInfoType | null
}

export interface MenuResponseType {
    data: MenuItemType[];
}
export interface MenuPageInfoResponseType {
    title: string
    page: PageInfoResponseType | null;
}
