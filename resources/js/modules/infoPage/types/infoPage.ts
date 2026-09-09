export interface PageInfoType {
    title: string;
    blocks: PageBlockType[];
}
export interface PageInfoResponseType {
    title: string;
    blocks: PageBlockType[];
}

export interface PageBlockType {
    id: number;
    title: string | null;
    text: string | null;
    filePath: string | null;
    published: string
}
