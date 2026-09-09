export interface LinksType {
    first: string | null,
    last: string | null,
    next: string | null,
    prev: string | null
}

export interface MetaType {
    current_page: number,
    from: number,
    last_page: number,
    links: MetaLink[],
    path: string,
    per_page: number,
    to: number,
    total: number,
}

interface MetaLink {
    active: boolean,
    label: string,
    page: number | null,
    url: string | null,
}
