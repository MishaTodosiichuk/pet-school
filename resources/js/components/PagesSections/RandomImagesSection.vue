<script setup>
import ImagesLightbox from "@/components/Sliders/ImagesLightbox.vue";

import {useImageStore} from "@/stores/image.ts";
import {onMounted, ref} from "vue";
import {storeToRefs} from "pinia";

const imageStore = useImageStore()

const {randomImages} = storeToRefs(imageStore);
const activeIndex = ref(null);

onMounted(async () => {
    await imageStore.getRandomImages()
})
</script>

<template>
    <section class="section">
        <h2 class="heading-line">Випадкові фото</h2>
        <div class="random-images">
            <div
                v-for="(randomImage, index) in randomImages"
                :key="index"
                class="image-item"
                @click="activeIndex = index"
            >
                <img :src="randomImage.url" :alt="randomImage.alt" width="150" height="150">
            </div>
        </div>
        <ImagesLightbox
            v-if="randomImages.length"
            :images="randomImages"
            v-model="activeIndex"
        />
    </section>
</template>

<style scoped lang="scss">
.random-images {
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
