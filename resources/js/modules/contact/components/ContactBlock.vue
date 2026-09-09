<script setup lang="ts">
import {useContactStore} from "@/modules/contact/stores/contactStore";
import {storeToRefs} from "pinia";

const contactStore = useContactStore()
const {contact} = storeToRefs(contactStore)

const {
    code_edrpou = '',
    zip_code = '',
    address = '',
    schedule = '',
    email = '',
    phone_number = '',
    head_institution = '',
} = contact.value || {}
</script>

<template>
    <ul class="contacts-block">
        <li><span>Код ЄДРПОУ:</span> <strong>{{ code_edrpou }}</strong></li>
        <li><span>Поштовий індекс:</span> <strong>{{ zip_code }}</strong></li>
        <li><span>Адреса:</span> <strong>{{ address }}</strong></li>
        <li><span>Графік роботи:</span> <strong>{{ schedule }}</strong></li>
        <li><span>E-Mail адреса:</span> <strong>{{ email }}</strong></li>
        <li><span>Контактний телефон:</span> <strong>{{ phone_number }}</strong></li>
        <li><span>Керівник установи:</span> <strong>{{ head_institution }}</strong></li>
    </ul>
</template>

<style scoped lang="scss">
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
</style>
