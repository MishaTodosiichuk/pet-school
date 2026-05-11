<script setup lang="ts">
import {useGalleryStore} from "@/stores/galleryStore";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";
import GridImages from "@/components/GridImages.vue";

const galleryStore = useGalleryStore()

const {pageGallery} = storeToRefs(galleryStore)

onMounted(async () => {
    await galleryStore.getPageGallery()
})
</script>

<template>
    <section class="section">
        <div class="home-page">
            <h1 class="heading-line">Фотогалерея</h1>
        </div>
    </section>
    <section class="section">
        <GridImages :images="pageGallery?.images ?? []"/>
    </section>
</template>

<style scoped lang="scss">

</style>
