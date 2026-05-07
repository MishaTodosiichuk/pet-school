export interface ImageItem {
    url: string,
    alt: string,
    width: number,
    height: number,
}

export interface ImageResponse {
    data: ImageItem[];
}
