export interface MenuItem {
    title: string,
    slug: string,
    children?: MenuItem[]
}
export interface StaticMenuItem {
    title: string,
    link: string,
}

export interface MenuResponse {
    data: MenuItem[];
}
