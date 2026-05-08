import { ImageItemType } from "@/types/image";

export interface GalleryItemType {
    title: string,
    images: ImageItemType[]
}

export interface GalleryResponseType {
    data: GalleryItemType;
}
