<script setup lang="ts">

import {NewsItemType} from "@/types/news";
import NewsItemCard from "@/components/News/NewsItemCard.vue";

withDefaults(defineProps<{
    news: NewsItemType[] | null
}>(), {
    news: () => [],
})

</script>

<template>
    <div class="news-list" v-if="news?.length">

        <article
            v-for="item in news"
            :key="item.slug"
        >
            <NewsItemCard :news="item"/>
            <div class="hr"></div>
        </article>
    </div>
    <div v-else class="unfounded-block">
        <div class="unfounded-content">
            <p>Нам шкода, за заданими датами нічого не знайдено :(</p>
            <span>Спробуйте змінити фільтр</span>
        </div>
    </div>
</template>

<style scoped lang="scss">

.news-list {
    display: flex;
    flex-direction: column;

    .hr {
        margin: $space-5 0;
        height: 1px;
        background: $color-gray-300;

        @media (max-width: $breakpoint-md) {
            margin: $space-3 0;
        }
    }
}
.unfounded-block {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    min-height: 300px;
    width: 100%;
    font-family: $font-main;
    font-size: $font-size-xl;
    font-weight: 600;
    color: $color-gray-500;

    .unfounded-content {
        display: flex;
        flex-direction: column;
        gap: $space-4;
    }

    span {
        font-size: $font-size-md;
        font-weight: normal;
        color: $color-gray-400;
    }
}
</style>
