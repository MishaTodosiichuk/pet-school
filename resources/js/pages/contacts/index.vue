<script setup lang="ts">
import {useContactStore} from "@/stores/contactStore";
import {storeToRefs} from "pinia";

import ContactFormSection from "@/components/PagesSections/ContactFormSection.vue";
import MapSection from "@/components/PagesSections/MapSection.vue";

const contactStore = useContactStore()
const {contact} = storeToRefs(contactStore)

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

    <ContactFormSection />

    <div class="hr"></div>

    <MapSection />
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

.hr {
    height: 1px;
    width: 100%;
    background: $color-gray-200;

    @media (max-width: $breakpoint-md) {
        margin: $space-3 auto;
        background: $color-gray-300;
    }
}
</style>
