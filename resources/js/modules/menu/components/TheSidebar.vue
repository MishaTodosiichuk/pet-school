<script setup lang="ts">
import List from "./List.vue";
import {Organization, Schedule, SocialNetworks} from "@/modules/app/components";

</script>

<template>
    <aside class="sidebar-menu">
        <header class="sidebar-menu__head">
            <SocialNetworks size="36"/>
        </header>
        <List/>
        <Schedule/>
        <Organization/>
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
