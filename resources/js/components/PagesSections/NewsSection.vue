<script setup lang="ts">
import NewsList from "@/components/News/NewsList.vue";
import {NewsItemType} from "@/types/news";

withDefaults(defineProps<{
    withTitle?: boolean,
    news: NewsItemType[] | null
}>(), {
    withTitle: true,
})
</script>

<template>
    <section class="section">
        <h2 v-if="withTitle" class="heading-line">Новини</h2>
        <NewsList :news="news"/>
        <RouterLink to="/news" v-if="withTitle">
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
