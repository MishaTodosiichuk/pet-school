<script setup lang="ts">
import {storeToRefs} from "pinia";
import {onMounted} from "vue";
import {useNewsStore} from "@/modules/news/stores";
import {NewsSection} from "@/modules/news/components";
import {BaseSection, Datepicker, Pagination} from "@/modules/app/components";

const newsStore = useNewsStore()

const {news} = storeToRefs(newsStore)

const fetchNews = async (page = 1, append = false, dates = null) => {
    await newsStore.getNews(page, append, dates)
}

onMounted(async () => {
    await fetchNews()
})
</script>

<template>
    <BaseSection>
        <h1 class="heading-line">Новини</h1>
        <Datepicker
            :fetch-data="fetchNews"
        />
        <NewsSection
            :with-title="false"
            :news="news"
        />
        <Pagination
            :meta="newsStore.meta"
            :fetch-data="fetchNews"
        />
    </BaseSection>
</template>

<style scoped lang="scss">

</style>
