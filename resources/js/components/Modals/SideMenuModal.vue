<script setup>
import {ref, onMounted, onUnmounted} from 'vue';
import emitter from "@/eventBus.js";
import MenuList from "@/components/Sidebar/Menu/MenuList.vue";
import MenuSchedule from "@/components/Sidebar/MenuSchedule.vue";
import TheOrganization from "@/components/Sidebar/TheOrganization.vue";

const isOpen = ref(false);

const openMenu = () => {
    isOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeMenu = () => {
    isOpen.value = false;
    document.body.style.overflow = '';
};

onMounted(() => {
    emitter.on('open-side-menu', openMenu);
});

onUnmounted(() => {
    emitter.off('open-side-menu', openMenu);
    document.body.style.overflow = '';
});
</script>

<template>
    <div class="side-menu-container">
        <transition name="fade">
            <div v-if="isOpen" class="side-menu-overlay" @click="closeMenu"></div>
        </transition>

        <transition name="slide">
            <div v-if="isOpen" class="side-menu-content">
                <div class="side-menu-content__header">
                    <span class="side-menu-content__title">Меню навігації</span>
                    <button class="side-menu-content__close" @click="closeMenu">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="side-menu-content__body">
                    <MenuList/>
                    <TheOrganization class="mob"/>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped lang="scss">
.side-menu-container {
    z-index: 2000;
}

.side-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1001;
    backdrop-filter: blur(2px);
}

.side-menu-content {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    max-width: 30%;
    height: 100vh;
    background: $color-white;
    z-index: 1002;
    display: flex;
    flex-direction: column;
    box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);

    @media (max-width: $breakpoint-lg) {
        max-width: 100%;
    }

    &__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: $space-4 $space-6;
        background: $color-primary;
        color: white;
    }

    &__title {
        font-family: $font-heading;
        font-weight: 600;
        font-size: $font-size-lg;
    }

    &__close {
        background: none;
        border: none;
        color: white;
        font-size: $font-size-2xl;
        cursor: pointer;
        transition: 0.3s ease;

        &:hover {
            opacity: 0.7;
            transform: rotate(90deg);
        }
    }

    &__body {
        flex: 1;
        overflow-y: auto;
        padding: $space-4 0;

        &::-webkit-scrollbar {
            width: 6px;
        }

        &::-webkit-scrollbar-thumb {
            background: $color-gray-700;
            border-radius: 10px;
        }
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-enter-from, .slide-leave-to {
    transform: translateX(-100%);
}
</style>
