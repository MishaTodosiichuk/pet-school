<script setup lang="ts">
import {useNewsStore} from "@/stores/newsStore";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";

import NewsSection from "@/components/PagesSections/NewsSection.vue";
import Datepicker from "@/components/forms/inputs/datepicker.vue";
import Pagination from "@/components/Pagination.vue";

const newsStore = useNewsStore()

const {allNews} = storeToRefs(newsStore)

const fetchNews = async (page = 1, append = false, dates = null) => {
    await newsStore.getNewsAll(page, append, dates)
}

onMounted(async () =>{
    await fetchNews()
})
</script>

<template>
    <section class="section">
        <div class="home-page">
            <h1 class="heading-line">Новини</h1>
        </div>
    </section>
    <Datepicker
        :fetch-data="fetchNews"
    />
    <NewsSection
        :with-title="false"
        :news="allNews"
    />
    <Pagination
        :meta="newsStore.meta"
        :fetch-data="fetchNews"
    />
</template>

<style scoped lang="scss">

</style>
