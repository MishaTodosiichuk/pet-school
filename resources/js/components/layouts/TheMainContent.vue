<script setup>
import TopNavbar from "./TopNavbar.vue";
</script>

<template>
    <div class="main-content">
        <TopNavbar/>
        <div class="main-content__block">
            <RouterView></RouterView>
        </div>
    </div>


</template>

<style scoped lang="scss">

</style>
