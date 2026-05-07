<script setup>
import {onMounted} from 'vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Autoplay} from 'swiper/modules';
import {useGalleryStore} from "@/stores/gallery.ts";
import {storeToRefs} from 'pinia';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const modules = [Navigation, Pagination, Autoplay];
const galleryStore = useGalleryStore();
const {mainGallery, isLoading} = storeToRefs(galleryStore);

onMounted(() => {
    galleryStore.getMainGallery();
});
</script>

<template>
    <swiper
        v-if="mainGallery && mainGallery.images.length"
        :modules="modules"
        :slides-per-view="1"
        :space-between="20"
        :navigation="true"
        :pagination="{ clickable: true }"
        :autoplay="{ delay: 5000 }"
        :loop="true"
        class="main-slider"
    >
        <swiper-slide v-for="(image, index) in mainGallery.images" :key="index">
            <img
                class="swiper-image"
                :src="image.url"
                :alt="image.alt"
                :width="image.width"
                :height="image.height"
                loading="lazy"
            >
        </swiper-slide>
    </swiper>

    <div v-else-if="isLoading" class="loader">
        Завантаження галереї...
    </div>
</template>

<style scoped lang="scss">

.swiper {
    width: 100%;
    height: 430px;

    @media (max-width: $breakpoint-lg) {
        height: 300px;
    }

    @media (max-width: $breakpoint-sm) {
        height: 280px;
    }
}

.swiper-slide {
    overflow: hidden;
    height: 430px;
    display: flex;
    justify-content: center;
    align-items: center;

    @media (max-width: $breakpoint-lg) {
        height: 300px;
    }

    @media (max-width: $breakpoint-sm) {
        height: 280px;
    }
}

.swiper-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}


:deep(.swiper-pagination-bullet) {
    background: white !important;
}

:deep(.swiper-pagination-bullet-active) {
    background: $color-accent !important;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
}

:deep(.swiper-navigation-icon) {
    color: $color-accent;
    width: 20px !important;
    height: 20px !important;
}
</style>
