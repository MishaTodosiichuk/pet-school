<script setup lang="ts">
import {NewsType} from "@/modules/news/types/news";
import {BaseSection} from "@/modules/app/components";
import CardList from "./CardList.vue";

withDefaults(defineProps<{
    withTitle?: boolean,
    news: NewsType[] | null
}>(), {
    withTitle: true,
})
</script>

<template>
    <BaseSection>
        <h2 v-if="withTitle" class="heading-line">Новини</h2>
        <CardList :news="news"/>
        <RouterLink to="/news" v-if="withTitle">
            <button aria-disabled="false"
                    type="button"
                    class="el-button el-button--warning">
                <span class="">Переглянути усі</span>
            </button>
        </RouterLink>
    </BaseSection>
</template>
