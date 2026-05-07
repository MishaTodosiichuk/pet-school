<script setup>
import NewsList from "@/components/News/NewsList.vue";
</script>

<template>
    <section class="section">
        <h2 class="heading-line">Новини</h2>
        <NewsList/>
        <RouterLink to="/news" class="">
            <button aria-disabled="false"
                    type="button"
                    class="el-button el-button--warning">
                <span class="">Переглянути усі</span>
            </button>
        </RouterLink>
    </section>
</template>

<style scoped lang="scss">

</style>
