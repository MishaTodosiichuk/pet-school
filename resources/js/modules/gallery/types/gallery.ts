import {ImageType} from "@/modules/image/types";

export interface GalleryType {
    title: string,
    images: ImageType[]
}

export interface GalleryResponseType {
    data: GalleryType;
}
