<script setup lang="ts">
import MenuList from "@/components/Sidebar/Menu/MenuList.vue";
import MenuSchedule from "@/components/Sidebar/MenuSchedule.vue";
import TheOrganization from "@/components/Sidebar/TheOrganization.vue";
import SocialNetworks from "@/components/SocialNetworks.vue";
</script>

<template>
    <aside class="sidebar-menu">
        <header class="sidebar-menu__head">
            <SocialNetworks size="36"/>
        </header>
        <MenuList/>
        <MenuSchedule/>
        <TheOrganization/>
    </aside>
</template>

<style scoped lang="scss">
.sidebar-menu {
    display: none;
    width: 323px;
    box-shadow: $shadow-sm;
    border-right: 1px solid $color-gray-100;
    background: $color-white;
    min-height: 100vh;
    padding-bottom: $space-10;

    @media (min-width: 1025px) {
        display: block;
    }

    &__head {
        padding: $space-2 $space-4;
        background: $color-accent;
        display: flex;
        align-items: center;
        height: 60px;
    }
}
</style>
