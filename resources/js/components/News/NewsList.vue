<script setup>
import NewsItem from "./NewsItem.vue";

import {onMounted} from "vue";
import {useNewsStore} from "@/stores/news.ts";
import {storeToRefs} from "pinia";

const newsStore = useNewsStore()

const {news} = storeToRefs(newsStore);

onMounted(async () => {
    await newsStore.getNews()
})
</script>

<template>
    <div class="news-list">
        <article
            v-for="item in news"
            :key="item.slug"
        >
            <NewsItem :news="item"/>
            <div class="hr"></div>
        </article>
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
</style>
