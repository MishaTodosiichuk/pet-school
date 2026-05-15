<script setup lang="ts">
import {onMounted, reactive, computed, onUnmounted} from "vue";
import {useContactStore} from "@/stores/contactStore";
import {storeToRefs} from "pinia";
import {vMaska} from "maska/vue"
import {notify} from '@/utils/notify'
import {loadRecaptcha, removeRecaptcha} from "@/utils/recaptcha";

import { GoogleMap, CustomMarker } from 'vue3-google-map'

const center = { lat: 48.4494, lng: 25.919 }

const mapOptions = {
    disableDefaultUI: true,
    zoomControl: true,
}

declare global {
    interface Window {
        grecaptcha: any;
        recaptchaSiteKey: string;
        mapApiKey: string;
    }
}

const mapKey = window.mapApiKey;

const contactStore = useContactStore()
const {contact, errors, isSubmitting} = storeToRefs(contactStore)

const form = reactive({
    name: '',
    email: '',
    phone: '',
    message: ''
})

const countChar = computed(() => {
    return form.message.length
})

const maxMessageLength: number = 2000;


const clearForm = () => {
    form.name = '';
    form.email = '';
    form.phone = '';
    form.message = '';
}

const handleSubmit = async () => {
    window.grecaptcha.ready(async () => {
        try {
            const token = await window.grecaptcha.execute(window.recaptchaSiteKey, {action: 'feedback_submit'});

            const success = await contactStore.sendFeedback({
                ...form,
                captcha: token
            });

            if (success) {
                notify.success('Дякуємо! Повідомлення успішно надіслано!');
                clearForm();
            } else if (Object.keys(contactStore.errors).length === 0) {
                notify.error('Сталася помилка на сервері. Спробуйте пізніше.');
            }
        } catch (e) {
            notify.error('Помилка капчі');
        }
    });
}

onMounted(async () => {
    await contactStore.getContact();

    await loadRecaptcha(window.recaptchaSiteKey);
});

onUnmounted(() => {
    removeRecaptcha();
});
</script>

<template>
    <section class="section">
        <h1 class="heading-line">Контактна інформація</h1>

        <ul class="contacts-block">
            <li><span>Код ЄДРПОУ:</span> <strong>{{ contact?.code_edrpou }}</strong></li>
            <li><span>Поштовий індекс:</span> <strong>{{ contact?.zip_code }}</strong></li>
            <li><span>Адреса:</span> <strong>{{ contact?.address }}</strong></li>
            <li><span>Графік роботи:</span> <strong>{{ contact?.schedule }}</strong></li>
            <li><span>E-Mail адреса:</span> <strong>{{ contact?.email }}</strong></li>
            <li><span>Контактний телефон:</span> <strong>{{ contact?.phone_number }}</strong></li>
            <li><span>Керівник установи:</span> <strong>{{ contact?.head_institution }}</strong></li>
        </ul>
    </section>

    <div class="hr"></div>

    <section class="section">
        <h2 class="heading-line">Контактна форма</h2>

        <form @submit.prevent="handleSubmit" class="contact-form">
            <div class="form-group"
                 :class="{ 'has-error': errors.name }"
            >
                <label for="name">
                    Прізвище та ініціали <span>*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    placeholder="Введіть дані"
                >
                <span
                    v-if="errors.name"
                    class="error-msg">
                    {{ errors.name[0] }}
                </span>
            </div>

            <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email">
                    Адреса електронної пошти <span>*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    placeholder="Введіть дані"
                >
                <span
                    v-if="errors.email"
                    class="error-msg">
                    {{ errors.email[0] }}
                </span>
            </div>

            <div class="form-group">
                <label for="phone">Контактний телефон</label>
                <input
                    v-maska
                    data-maska="+38 (###) ###-##-##"
                    type="text"
                    id="phone"
                    v-model="form.phone"
                    placeholder="+38 (0__) ___-__-__"
                >
            </div>

            <div class="form-group" :class="{ 'has-error': errors.message }">
                <label for="message">Текст повідомлення <span>*</span></label>
                <div class="textarea-wrapper">
                    <textarea
                        id="message"
                        v-model="form.message"
                        placeholder="Ваше повідомлення..."
                        :maxlength="maxMessageLength"
                    ></textarea>
                    <div
                        class="char-counter"
                        :class="{ 'at-limit': countChar >= maxMessageLength }"
                    >
                        {{ countChar }} / {{ maxMessageLength }}
                    </div>
                </div>
                <span v-if="errors.message" class="error-msg">{{ errors.message[0] }}</span>
            </div>

            <button aria-disabled="false" type="submit" :disabled="isSubmitting"
                    class="el-button el-button--warning is-round">
                <span v-if="isSubmitting">Надсилання...</span>
                <span v-else>Надіслати</span>
            </button>
        </form>
    </section>

    <div class="hr"></div>

    <section class="section">
        <h2 class="heading-line">Карта</h2>

        <GoogleMap
            :api-key="mapKey"
            map-id="DEMO_MAP_ID"
            style="width: 100%; height: 450px; border-radius: 12px; overflow: hidden;"
            :center="center"
            :zoom="15"
            :options="mapOptions"
        >
            <CustomMarker :options="{ position: center }">
                <div class="map-marker-wrapper">
                    <div class="map-marker">
                        <div class="marker-content">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="marker-pulse"></div>
                    </div>
                </div>
            </CustomMarker>
        </GoogleMap>
    </section>
</template>

<style scoped lang="scss">
.map-marker-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.map-marker {
    position: relative;
    width: 40px;
    height: 40px;
    color: $color-accent;
    cursor: pointer;

    .marker-content {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.4));
    }

    .marker-pulse {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 12px;
        height: 12px;
        background-color: currentColor;
        border-radius: 50%;
        z-index: 1;
        opacity: 0.6;
        animation: marker-pulse 2s infinite ease-out;
    }
}

@keyframes marker-pulse {
    0% {
        transform: translateX(-50%) scale(1);
        opacity: 0.8;
    }
    100% {
        transform: translateX(-50%) scale(4);
        opacity: 0;
    }
}

.contacts-block {
    display: flex;
    flex-direction: column;
    gap: $space-4;

    li {
        display: flex;
        flex-wrap: wrap;
        font-size: $font-size-md;

        @media (max-width: $breakpoint-md) {
            flex-direction: column;
            font-size: $font-size-lg;
        }

        span {
            color: $color-gray-600;
            margin-right: $space-2;
        }

        strong {
            font-weight: 600;
            color: $color-black;
        }
    }
}

.hr {
    height: 1px;
    width: 100%;
    background: $color-gray-200;

    @media (max-width: $breakpoint-md) {
        margin: $space-3 auto;
        background: $color-gray-300;
    }
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: $space-4;
    font-family: $font-main;
    width: 100%;

    .form-group {
        display: flex;
        flex-direction: column;
        gap: $space-1;

        label {
            color: $color-gray-700;
            font-weight: 500;

            span {
                color: $color-error;
            }
        }

        input, textarea {
            padding: $space-3;
            border: 1px solid $color-gray-300;
            border-radius: $space-2;
            font-family: inherit;
            outline: none;
            transition: border-color 0.3s;

            &:focus {
                border-color: $color-primary;
            }
        }

        .textarea-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;

            textarea {
                padding-bottom: $space-8;
            }

            .char-counter {
                position: absolute;
                bottom: $space-2;
                right: $space-3;
                font-size: $font-size-sm;
                font-family: 'Instrument Sans', sans-serif;
                color: $color-gray-500;
                pointer-events: none;
                transition: color 0.3s ease;

                &.at-limit {
                    color: $color-error;
                    font-weight: 600;
                }
            }
        }

        textarea {
            min-height: 120px;
        }

        &.has-error {
            input {
                border-color: $color-error;
            }

            .error-msg {
                color: $color-error;
                font-size: $font-size-sm;
            }

            .textarea-wrapper textarea {
                border-color: $color-error;
            }

            .char-counter {
                bottom: $space-2;
            }
        }
    }

    button {
        width: 363px;
        height: 48px;

        @media (max-width: $breakpoint-md) {
            width: 100%;
        }
    }
}
</style>
