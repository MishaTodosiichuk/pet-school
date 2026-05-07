<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { ArrowUp } from "@element-plus/icons-vue"

const isVisible = ref(false)
let lastScrollTop = 0

const handleScroll = () => {
    const currentScrollTop = window.scrollY || document.documentElement.scrollTop

    const isScrollingUp = currentScrollTop < lastScrollTop
    const isNotAtTop = currentScrollTop > 300

    isVisible.value = isScrollingUp && isNotAtTop
    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop
}

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <transition name="back-top-fade">
        <div
            v-show="isVisible"
            class="back-to-top-wrapper"
            @click="scrollToTop"
        >
            <button
                class="back-to-top-button"
                aria-label="Повернутися вгору"
            >
                <el-icon><ArrowUp /></el-icon>
            </button>
        </div>
    </transition>
</template>

<style scoped lang="scss">
.back-to-top-wrapper {
    position: fixed;
    z-index: 999;
    bottom: 40px;
    right: 40px;
    cursor: pointer;

    @media (max-width: 1024px) {
        bottom: 80px;
        right: 20px;
    }
}

.back-to-top-button {
    width: 50px;
    height: 50px;
    background-color: $color-white;
    color: $color-deep-primary;
    border: 2px solid $color-deep-primary;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;

    .el-icon {
        font-size: 24px;
        stroke-width: 2px;
    }

    &:hover {
        background-color: $color-deep-primary;
        color: $color-white;
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }
}

.back-top-fade-enter-active,
.back-top-fade-leave-active {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.back-top-fade-enter-from,
.back-top-fade-leave-to {
    opacity: 0;
    transform: scale(0.5) translateY(30px);
}
</style>
