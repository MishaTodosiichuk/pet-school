<script setup lang="ts">

import {onMounted} from "vue";

import {storeToRefs} from "pinia";
import {useNewsStore} from "@/modules/news/stores";
import {NewsSection} from "@/modules/news/components";
import {MainSwiper} from "@/modules/gallery/components";
import {RandomImagesSection} from "@/modules/image/components";
import {BaseSection} from "@/modules/app/components";

const newsStore = useNewsStore()

const {news} = storeToRefs(newsStore)

onMounted(async () => {
    await newsStore.getNews()
})
</script>

<template>
    <BaseSection>
        <h1 class="heading-line">Головна</h1>
        <p>Раді вітати на сайті нашої школи! Це місце, де народжуються мрії, формується особистість та закладається
            фундамент успішного майбутнього. Ми прагнемо створити простір, у якому кожен учень почувається впевнено,
            розвиває свої таланти та знаходить вірних друзів. Наш заклад — це не просто стіни та підручники, це
            велика родина, де панує взаємоповага, творчість та жага до знань. Ми відкриті до нових ідей і завжди
            раді бачити вас серед нашої спільноти!</p>
    </BaseSection>
    <BaseSection>
        <div class="home-slider">
            <MainSwiper/>
        </div>
    </BaseSection>
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
