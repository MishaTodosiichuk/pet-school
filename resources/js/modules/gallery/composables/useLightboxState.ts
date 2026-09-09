import { ref, watch, nextTick, computed } from 'vue';
import type { Swiper as SwiperClass } from 'swiper';
import { useModalLock } from './useModalLock';

export function useSwiperLightbox(
    modelValue: () => number | null,
    emitClose: () => void
) {
    const swiperInstance = ref<SwiperClass | null>(null);
    const isOpen = computed(() => modelValue() !== null);

    const onSwiper = (swiper: SwiperClass) => {
        swiperInstance.value = swiper;
    };

    const close = () => {
        emitClose();
    };

    useModalLock(isOpen, close);

    watch(modelValue, async (newIndex) => {
        if (newIndex !== null) {
            await nextTick();
            if (swiperInstance.value) {
                swiperInstance.value.slideTo(newIndex, 0);
                swiperInstance.value.update();
            }
        }
    }, { immediate: true });

    return {
        swiperInstance,
        onSwiper,
        close
    };
}
