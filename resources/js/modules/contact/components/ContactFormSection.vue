<script setup lang="ts">
import {vMaska} from "maska/vue"
import {useContactStore} from "@/modules/contact/stores/contactStore"
import {storeToRefs} from "pinia"
import {onMounted, reactive} from "vue"
import {useNotify} from '@/modules/app/composables/useNotify'
import {useRecaptcha} from '@/modules/app/composables/useRecaptcha'
import {BaseSection} from "@/modules/app/components";
import FormGroup from "./formBlocks/FormGroup.vue";
import Textarea from "./formBlocks/Textarea.vue";

const {successNotify, errorNotify} = useNotify()
const {executeRecaptcha} = useRecaptcha()

const contactStore = useContactStore()
const {errors, isSubmitting} = storeToRefs(contactStore)

const form = reactive({
    name: '',
    email: '',
    phone: '',
    message: ''
})

const clearForm = () => {
    form.name = ''
    form.email = ''
    form.phone = ''
    form.message = ''
}

const handleSubmit = async () => {
    const token = await executeRecaptcha('feedback_submit')

    if (!token) return

    const success = await contactStore.sendFeedback({
        ...form,
        captcha: token
    })

    if (success) {
        successNotify('Дякуємо! Повідомлення успішно надіслано!')
        clearForm()
    } else if (Object.keys(errors.value).length === 0) {
        errorNotify('Сталася помилка на сервері. Спробуйте пізніше.')
    }
}

onMounted(async () => {
    await contactStore.getContact()
})
</script>

<template>
    <BaseSection>
        <h2 class="heading-line">Контактна форма</h2>

        <form @submit.prevent="handleSubmit" class="contact-form">
            <FormGroup
                id="name"
                label="Прізвище та ініціали"
                :is-required="true"
                placeholder="Введіть дані"
                v-model="form.name"
                :errors="errors.name"
            />

            <FormGroup
                id="email"
                type="email"
                label="Адреса електронної пошти"
                :is-required="true"
                placeholder="Введіть дані"
                v-model="form.email"
                :errors="errors.email"
            />

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

            <Textarea
                v-model="form.message"
                :errors="errors.message"
            />

            <button
                type="submit"
                :disabled="isSubmitting"
                class="el-button el-button--warning is-round"
            >
                <span v-if="isSubmitting">Надсилання...</span>
                <span v-else>Надіслати</span>
            </button>
        </form>
    </BaseSection>
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

        input {
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

        &.has-error {
            input {
                border-color: $color-error;
            }

            .error-msg {
                color: $color-error;
                font-size: $font-size-sm;
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
