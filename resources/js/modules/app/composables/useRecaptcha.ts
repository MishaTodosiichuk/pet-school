import {useNotify} from '@/modules/app/composables/useNotify'

declare global {
    interface Window {
        grecaptcha?: {
            ready: (cb: () => void) => void
            execute: (siteKey: string, options: { action: string }) => Promise<string>
        }
        recaptchaSiteKey?: string
    }
}

export const loadRecaptcha = (siteKey: string): Promise<void> => {
    return new Promise((resolve) => {
        if (window.grecaptcha) {
            resolve();
            return;
        }

        const script = document.createElement('script');
        script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey}`;
        script.async = true;
        script.defer = true;
        script.onload = () => {
            window.grecaptcha?.ready(() => resolve());
        };
        document.head.appendChild(script);
    });
};

export const removeRecaptcha = () => {
    const script = document.querySelector(`script[src*="recaptcha/api.js"]`);
    if (script) script.remove();

    const badge = document.querySelector('.grecaptcha-badge');
    if (badge) badge.remove();

    delete window.grecaptcha;
};

// Додаємо експорт useRecaptcha, якого бракувало
export function useRecaptcha() {
    const {errorNotify} = useNotify

    const executeRecaptcha = async (action: string): Promise<string | null> => {
        try {
            const siteKey = window.recaptchaSiteKey

            if (!siteKey) {
                errorNotify('reCAPTCHA siteKey не вказано')
                return null
            }

            await loadRecaptcha(siteKey)

            if (!window.grecaptcha) {
                errorNotify('Сервіс reCAPTCHA недоступний')
                return null
            }

            return await window.grecaptcha.execute(siteKey, {action})
        } catch (error) {
            errorNotify('Помилка під час виконання reCAPTCHA')
            return null
        }
    }

    return {
        executeRecaptcha,
        loadRecaptcha,
        removeRecaptcha
    }
}
