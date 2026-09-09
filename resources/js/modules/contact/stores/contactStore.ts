import {defineStore} from 'pinia'
import {ContactType, formDataType} from "@/modules/contact/types/contact";
import { useLoading } from '@/modules/app/composables/useLoading'
import {apiContact} from "@/modules/contact/api";

const {showLoading, hideLoading} = useLoading()

export const useContactStore = defineStore('contact', {
    state: () => ({
        contact: null as ContactType | null,
        errors: {} as Record<string, string[]>,
        isSubmitting: false
    }),

    getters: {},

    actions: {
        async getContact() {
            await showLoading()
            try {
                const {data} = await apiContact.getContact()
                this.contact = data.data
            } catch (error) {
                console.error('Помилка завантаження ' + error);
                return null;
            } finally {
                hideLoading()
            }
        },
        async sendFeedback(formData: formDataType) {
            this.isSubmitting = true;
            this.errors = {};
            await showLoading()
            try {
                await apiContact.sendFeedback(formData);
                return true;
            } catch (error: any) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                console.error('Помилка відправки', error);
                return false;
            } finally {
                this.isSubmitting = false;
                hideLoading()
            }
        }
    }
});
