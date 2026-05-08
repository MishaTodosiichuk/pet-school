<script setup lang="ts">
import ImagesLightbox from "@/components/Sliders/ImagesLightbox.vue";
import {ref} from "vue";
import {ImageItemType} from "@/types/image";

withDefaults(defineProps<{
    images: ImageItemType[] | null
}>(),{
    images: () => []
})

const activeIndex = ref<number | null>(null);
</script>

<template>
    <div class="images-block">
        <div
            v-for="(image, index) in images"
            :key="index"
            class="image-item"
            @click="activeIndex = index"
        >
            <img :src="image.url" :alt="image.alt" width="150" height="150">
        </div>
    </div>
    <ImagesLightbox
        v-if="images?.length"
        :images="images"
        v-model="activeIndex"
    />
</template>

<style scoped lang="scss">
.images-block {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: $space-4;

    @media (max-width: $breakpoint-md) {
        grid-template-columns: repeat(2, 1fr);
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
        transition: 0.3s ease;

        &:hover {
            box-shadow: $shadow-lg;
            transform: translateY(-2px);
        }
    }
}
</style>
