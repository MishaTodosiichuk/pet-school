<script setup lang="ts">

import MainSwiper from "@/components/Sliders/MainSwiper.vue";
import RandomImagesSection from "@/components/PagesSections/RandomImagesSection.vue";
import NewsSection from "@/components/PagesSections/NewsSection.vue";
import {onMounted} from "vue";
import {useNewsStore} from "@/stores/newsStore";
import {storeToRefs} from "pinia";

const newsStore = useNewsStore()

const {news} = storeToRefs(newsStore)

onMounted(async () => {
    await newsStore.getNews()
})
</script>

<template>
    <section class="section">
        <div class="home-page">
            <h1 class="heading-line">Головна</h1>
            <p>Раді вітати на сайті нашої школи! Це місце, де народжуються мрії, формується особистість та закладається
                фундамент успішного майбутнього. Ми прагнемо створити простір, у якому кожен учень почувається впевнено,
                розвиває свої таланти та знаходить вірних друзів. Наш заклад — це не просто стіни та підручники, це
                велика родина, де панує взаємоповага, творчість та жага до знань. Ми відкриті до нових ідей і завжди
                раді бачити вас серед нашої спільноти!</p>
        </div>
    </section>
    <section class="section">
        <div class="home-slider">
            <MainSwiper/>
        </div>
    </section>
    <NewsSection :news="news"/>
    <RandomImagesSection/>
</template>

<style scoped lang="scss">

.home-slider {
    width: 100%;
    max-height: 500px;
    margin: 0 auto;
}

</style>
