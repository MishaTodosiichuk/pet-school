<script setup>
import {onUnmounted, ref, watch} from 'vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Keyboard} from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const props = defineProps({
    images: {type: Array, required: true},
    modelValue: {type: [Number, null], default: null}
});

const emit = defineEmits(['update:modelValue']);

const modules = [Navigation, Pagination, Keyboard];
const swiperInstance = ref(null);

const onSwiper = (swiper) => {
    swiperInstance.value = swiper;
};

const close = () => {
    emit('update:modelValue', null);
};

watch(() => props.modelValue, (newIndex) => {
    if (newIndex !== null) {
        document.body.style.overflow = 'hidden';

        if (swiperInstance.value) {
            swiperInstance.value.slideTo(newIndex, 0);
        }
    } else {
        document.body.style.overflow = '';
    }
}, {immediate: true});

onUnmounted(() => {
    document.body.style.overflow = '';
});
</script>

<template>
    <Transition name="fade">
        <div v-if="modelValue !== null" class="lightbox-overlay" @click.self="close">
            <button class="close-btn" @click="close" aria-label="Закрити">×</button>

            <div class="lightbox-container">
                <swiper
                    :modules="modules"
                    :slides-per-view="1"
                    :space-between="50"
                    :initial-slide="modelValue"
                    navigation
                    :keyboard="{ enabled: true }"
                    :pagination="{ type: 'fraction' }"
                    @swiper="onSwiper"
                    class="lightbox-swiper"
                >
                    <swiper-slide v-for="(image, index) in images" :key="index">
                        <div class="image-wrapper">
                            <img :src="image.url" :alt="image.alt" class="lightbox-image">
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </Transition>
</template>

<style scoped lang="scss">
.lightbox-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-container {
    width: 90%;
    max-width: 1200px;
    height: 70%;
}

.lightbox-swiper {
    width: 100%;
    height: 100%;

    :deep(.swiper-button-next), :deep(.swiper-button-prev) {
        color: white;

        &::after {
            font-size: $font-size-2xl;
        }
    }

    :deep(.swiper-pagination-fraction) {
        bottom: -30px;
    }
}

.image-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;

    .lightbox-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 30px;
    background: none;
    border: none;
    color: #fff;
    font-size: 3.125rem;
    cursor: pointer;
    z-index: 10000;
    line-height: 1;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
