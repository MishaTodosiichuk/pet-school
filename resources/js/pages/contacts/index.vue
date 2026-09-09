<script setup lang="ts">

import {ContactBlock} from "@/modules/contact/components";
import {ContactFormSection} from "@/modules/contact/components";
import {BaseLine, BaseSection, MapSection} from "@/modules/app/components";

</script>

<template>
    <BaseSection>
        <h1 class="heading-line">Контактна інформація</h1>

        <ContactBlock/>
    </BaseSection>

    <BaseLine />

    <ContactFormSection/>

    <BaseLine />

    <MapSection/>
</template>
