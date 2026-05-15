<script setup lang="ts">
import {vMaska} from "maska/vue"
import {useContactStore} from "@/stores/contactStore";
import {storeToRefs} from "pinia";
import {computed, onMounted, reactive} from "vue";
import {notify} from "@/utils/notify";

const contactStore = useContactStore()
const {errors, isSubmitting} = storeToRefs(contactStore)

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
});

</script>

<template>
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
</template>

<style scoped lang="scss">
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
