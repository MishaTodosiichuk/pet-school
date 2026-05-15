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
            window.grecaptcha.ready(() => resolve());
        };
        document.head.appendChild(script);
    });
};

export const removeRecaptcha = () => {
    const script = document.querySelector(`script[src*="recaptcha/api.js"]`);
    if (script) script.remove();

    const badge = document.querySelector('.grecaptcha-badge');
    if (badge) badge.remove();

    window.grecaptcha = undefined;
};
