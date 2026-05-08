export interface MenuItemType {
    title: string,
    slug: string,
    children?: MenuItemType[]
}
export interface StaticMenuItemType {
    title: string,
    link: string,
}

export interface MenuResponseType {
    data: MenuItemType[];
}
