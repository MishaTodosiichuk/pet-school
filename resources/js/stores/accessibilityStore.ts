import { defineStore } from 'pinia'

import { AccessibilityState } from '@/types/accessibility'
export const useAccessibilityStore = defineStore('accessibility', {
    state: (): AccessibilityState => ({
        isContrast: localStorage.getItem('accessibility-contrast') === 'true',
        fontSize: Number(localStorage.getItem('accessibility-font')) || 100,
    }),

    actions: {
        toggleContrast(): void {
            this.isContrast = !this.isContrast;
            localStorage.setItem('accessibility-contrast', String(this.isContrast));
        },

        setFontSize(size: number): void {
            this.fontSize = size;
            localStorage.setItem('accessibility-font', String(size));
        }
    }
})
