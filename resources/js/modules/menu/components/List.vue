<script setup lang="ts">
import Card from "./Card.vue";
import {onMounted, ref, provide} from "vue";
import {storeToRefs} from "pinia";
import {useMenuStore} from "@/modules/menu/stores";

const menuStore = useMenuStore();
const {menus} = storeToRefs(menuStore);

const activeParentSlug = ref<string | null>(null);

const toggleParent = (slug: string) => {
    activeParentSlug.value = activeParentSlug.value === slug ? null : slug;
};

provide("activeParentSlug", activeParentSlug);
provide("toggleParent", toggleParent);

onMounted(async () => {
    await menuStore.getMenus();
});
</script>

<template>
    <nav aria-label="Бічне меню">
        <ul class="sidebar-menu__list">
            <template v-for="menu in menus" :key="menu?.slug">
                <Card :menu="menu"/>
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
