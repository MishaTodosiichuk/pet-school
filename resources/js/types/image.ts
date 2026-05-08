export interface ImageItemType {
    url: string,
    alt: string,
    width: number,
    height: number,
}

export interface ImageResponseType {
    data: ImageItemType[];
}
