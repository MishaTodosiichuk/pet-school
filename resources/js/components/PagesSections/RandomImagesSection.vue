<script setup lang="ts">
import {useImageStore} from "@/stores/imageStore";
import {onMounted} from "vue";
import {storeToRefs} from "pinia";
import GridImages from "@/components/GridImages.vue";

const imageStore = useImageStore()

const {randomImages} = storeToRefs(imageStore);

onMounted(async () => {
    await imageStore.getRandomImages()
})
</script>

<template>
    <section class="section">
        <h2 class="heading-line">Випадкові фото</h2>
        <GridImages :images="randomImages"/>
    </section>
</template>

<style scoped lang="scss">

</style>
