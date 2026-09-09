import axios from "axios";
import type { AxiosResponse } from 'axios'
import {MenuResponseType} from "@/modules/menu/types";

export const apiMenus = {
    getMenus(): Promise<AxiosResponse<MenuResponseType>>{
        return axios.get<MenuResponseType>('/api/menu')
    }
}
