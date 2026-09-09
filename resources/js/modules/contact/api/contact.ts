import {ContactResponse, formDataType} from "@/modules/contact/types";
import axios from "axios";

export const apiContact = {
    getContact() {
        return axios.get<ContactResponse>(`/api/get-contact-info`)
    },

    sendFeedback(formData: formDataType) {
        return axios.post(`/api/contact-feedback`, formData)
    }
}

