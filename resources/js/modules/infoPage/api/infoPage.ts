import axios from "axios";
import {MenuPageInfoResponseType} from "@/modules/menu/types";

export const apiInfoPage = {
    getPageData (slug: string) {
        return axios.get<MenuPageInfoResponseType>(`/api/page-info-by-slug/${slug}`);
    }
}
