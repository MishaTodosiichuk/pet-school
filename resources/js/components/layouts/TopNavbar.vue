<script setup>

import {useRoute} from "vue-router";
import {useMenuStore} from "@/stores/menu.ts";
import {storeToRefs} from "pinia";

const route = useRoute()

const menuStore = useMenuStore()

const {staticMenu} = storeToRefs(menuStore);

</script>

<template>
    <nav class="navbar-menu" aria-label="Основна навігація" id="main-navigate">
        <ul class="navbar-menu__list">
            <li
                v-for="(menu, index) in staticMenu"
                :key="index"
                class="navbar-menu__list-item"
                :class="{ 'active': route.path === menu.link }"
            >
                <RouterLink :to="menu.link">
                    {{ menu.title }}
                </RouterLink>
            </li>
        </ul>
    </nav>
</template>

<style scoped lang="scss">
.navbar-menu {
    background: $color-primary;
    padding: 0 $space-8;
    width: 100%;
    height: 60px;
    display: flex;

    @media (max-width: $breakpoint-lg) {
        border-radius: 4px;
        padding: 0 $space-4;
    }

    @media (max-width: $breakpoint-md) {
        display: none;
    }

    &__list {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        gap: $space-6;
        color: white;
        list-style: none;
        margin: 0;
        padding: 0;
        text-transform: uppercase;
        font-family: $font-main;
        font-weight: normal;
        font-size: clamp(0.875rem, 1.4vw + 0rem, 1.25rem);

        @media (max-width: $breakpoint-lg) {
            font-size: clamp(1rem, 1.6vw + 0.3rem, 1.25rem);
        }

        &-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            white-space: nowrap;

            &:hover, &.active {
                color: $color-accent;
            }

            &.active {
                color: $color-accent;
                border-bottom-color: $color-accent;
            }
        }
    }
}
</style>
