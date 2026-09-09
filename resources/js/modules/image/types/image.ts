export interface ImageType {
    url: string,
    alt: string,
    width: number,
    height: number,
}

export interface ImageResponseType {
    data: ImageType[];
}
