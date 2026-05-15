import {defineStore} from 'pinia'
import axios from "axios";
import {ContactResponse, ContactType} from "@/types/contact";
import {loading} from '@/utils/loading'

export const useContactStore = defineStore('contact', {
    state: () => ({
        contact: null as ContactType | null,
        errors: {} as Record<string, string[]>,
        isSubmitting: false
    }),

    getters: {},

    actions: {
        async getContact() {
            await loading.show()
            try {
                const {data} = await axios.get<ContactResponse>(`/api/get-contact-info`)
                this.contact = data.data
            } catch (error) {
                console.error('Помилка завантаження ' + error);
                return null;
            } finally {
                loading.hide()
            }
        },
        async sendFeedback(formData: any) {
            this.isSubmitting = true;
            this.errors = {};
            await loading.show()
            try {
                await axios.post('/api/contact-feedback', formData);
                return true;
            } catch (error: any) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                console.error('Помилка відправки', error);
                return false;
            } finally {
                this.isSubmitting = false;
                loading.hide()
            }
        }
    }
});
