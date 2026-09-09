<script setup lang="ts">

import {onMounted} from "vue";
import {storeToRefs} from "pinia";

import {GridImages} from "@/modules/image/components";
import {useImageStore} from "@/modules/image/stores";
import {BaseSection} from "@/modules/app/components";

const imageStore = useImageStore()

const {randomImages} = storeToRefs(imageStore);

onMounted(async () => {
    await imageStore.getRandomImages()
})
</script>

<template>
    <BaseSection>
        <h2 class="heading-line">Випадкові фото</h2>
    </BaseSection>
    <BaseSection>
        <GridImages :images="randomImages"/>
    </BaseSection>
</template>

<style scoped lang="scss">

</style>
