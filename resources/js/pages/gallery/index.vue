<script setup lang="ts">
import {useGalleryStore} from "@/modules/gallery/stores/galleryStore";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";
import {GridImages} from "@/modules/image/components";
import {BaseSection} from "@/modules/app/components";

const galleryStore = useGalleryStore()

const {pageGallery} = storeToRefs(galleryStore)

onMounted(async () => {
    await galleryStore.getPageGallery()
})
</script>

<template>
    <BaseSection>
        <h1 class="heading-line">Фотогалерея</h1>
    </BaseSection>
    <BaseSection>
        <GridImages :images="pageGallery?.images ?? []"/>
    </BaseSection>
</template>

<style scoped lang="scss">

</style>
