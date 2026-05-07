<script setup>
import {ref, onMounted, onBeforeUnmount} from 'vue'
import TopNavbar from "../layouts/TopNavbar.vue";
import emitter from "@/eventBus.js";

const isStickyVisible = ref(false)
let observer = null

onMounted(() => {
    const target = document.getElementById('main-navigate')

    if (target) {
        observer = new IntersectionObserver(([entry]) => {
            isStickyVisible.value = !entry.isIntersecting
        }, {
            threshold: 0,
            rootMargin: '-53px 0px 0px 0px'
        })

        observer.observe(target)
    }
})

onBeforeUnmount(() => {
    if (observer) {
        observer.disconnect()
    }
})
</script>

<template>
    <transition name="fade-slide">
        <div v-if="isStickyVisible" class="sticky-menu">
            <div class="container-site">
                <div class="sticky-menu-block">
                    <div class="sticky-menu-block__left">
                        <i class="fas fa-bars" @click="emitter.emit('open-side-menu')"></i>
                    </div>
                    <TopNavbar style="width: fit-content; padding: 0;"/>
                </div>

            </div>
        </div>
    </transition>
</template>

<style scoped lang="scss">
.sticky-menu {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 900;
    background: $color-primary;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px;
}
.container-site {
    @media (max-width: $breakpoint-xl) {
        width: 100% !important;
    }
}

.sticky-menu-block {
    display: flex;
    justify-content: space-between;
    align-items: center;

    &__left {
        i {
            font-size: 1.75rem;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;

            &:hover {
                color: $color-gray-400;
            }
        }
    }
}

.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    transform: translateY(-100%);
    opacity: 0;
}
</style>
