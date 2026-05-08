<script setup lang="ts">
import MenuItemCard from "@/components/Sidebar/Menu/MenuItemCard.vue";

import {onMounted} from "vue";
import {useMenuStore} from "@/stores/menuStore";
import {storeToRefs} from "pinia";

const menuStore = useMenuStore()

const {menus} = storeToRefs(menuStore);

onMounted(async () => {
    await menuStore.getMenus()
})
</script>

<template>
    <nav aria-label="Бічне меню">
        <ul class="sidebar-menu__list">
            <template
                v-for="menu in menus"
                :key="menu?.slug">
                <MenuItemCard :menu="menu"/>
            </template>
        </ul>
    </nav>
</template>

<style scoped lang="scss">

.sidebar-menu {
    &__list {
        display: flex;
        flex-direction: column;
        background: $color-white;
        padding: $space-2 $space-4 $space-6;
        list-style: none;
        overflow: hidden;
    }
}
</style>
