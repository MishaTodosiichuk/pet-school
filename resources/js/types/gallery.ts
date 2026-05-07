import { ImageItem } from "@/types/image";

export interface GalleryItem {
    title: string,
    images: ImageItem[]
}

export interface GalleryResponse {
    data: GalleryItem;
}
