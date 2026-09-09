<script setup lang="ts">

import {useRoute} from "vue-router";
import {onMounted} from "vue";
import {useNewsStore} from "@/modules/news/stores/";
import {storeToRefs} from "pinia";
import {useShare} from "@/modules/news/composables/useShare";
import {GridImages} from "@/modules/image/components";
import {BaseSection, BaseLine} from "@/modules/app/components";

const route = useRoute()

const newsStore = useNewsStore()
const {share} = useShare()

const {singleNews} = storeToRefs(newsStore)

const slug = route.params.slug as string

onMounted(async () => {
    await newsStore.getNewsBySlug(slug)

    if (singleNews.value) {
        await newsStore.incrementViews(singleNews.value.slug)
    }
})

</script>

<template>
    <BaseSection>
        <div v-if="singleNews" class="news-page">
            <h1 class="heading-line">{{ singleNews?.title }}</h1>

            <BaseSection>
                <div class="news-page__info">
                    <div>Дата: <span>{{ singleNews?.published }}</span></div>
                    <div>Кількість переглядів: <span>{{ singleNews?.viewsCount }}</span></div>
                    <div class="share">
                        <button type="button" @click="share('facebook', singleNews.title)">
                            <i class="fab fa-facebook"></i>
                        </button>

                        <button type="button" @click="share('telegram', singleNews.title)">
                            <i class="fab fa-telegram"></i>
                        </button>

                        <button type="button" @click="share('viber', singleNews.title)">
                            <i class="fab fa-viber"></i>
                        </button>

                        <button type="button" @click="share('print', singleNews.title)">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
            </BaseSection>

            <BaseLine />

            <BaseSection>
                <div class="news-page__image">
                    <img
                        :src="singleNews?.image?.url"
                        :alt="singleNews?.image?.alt"
                    >
                </div>
            </BaseSection>

            <BaseLine />

            <BaseSection>
                <div class="news-page__description" v-html="singleNews?.description"></div>
            </BaseSection>

            <BaseLine />

            <BaseSection>
                <h2 class="heading-line">Всі фотографії</h2>
            </BaseSection>
            <BaseSection>
                <GridImages :images="singleNews?.images"/>
            </BaseSection>
        </div>

        <div v-else class="news-page skeleton">
            <div class="skeleton__title"></div>
            <div class="skeleton__info">
                <div class="skeleton__line short"></div>
                <div class="skeleton__line short"></div>
                <div class="skeleton__share"></div>
            </div>
            <div class="skeleton__image"></div>
            <div class="skeleton__text"></div>
            <div class="skeleton__text"></div>
        </div>
    </BaseSection>
</template>

<style scoped lang="scss">
.news-page {
    &__info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        font-family: $font-main;
        color: $color-gray-500;
        font-size: $font-size-md;

        @media (max-width: $breakpoint-md) {
            flex-direction: column;
            align-items: start;
            justify-content: center;
            gap: $space-2;
        }

        span {
            color: #000;
        }

        .share {
            display: flex;
            gap: $space-2;
            align-items: center;

            i {
                font-size: 28px;
                transition: 0.3s ease;

                &:hover {
                    transform: translateY(-2px);
                    filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));
                }
            }

            .fa-facebook {
                color: #0064E0;
            }

            .fa-telegram {
                color: #26A5E4;
            }

            .fa-viber {
                color: #7360F2;
            }

            .fa-print {
                color: #4B5563;
            }
        }
    }

    &__image {
        width: 100%;
        height: 450px;
        display: flex;
        justify-content: center;

        img {
            max-width: 600px;
            height: 100%;
            object-fit: cover;

            @media (max-width: $breakpoint-md) {
                max-width: 100%;
            }
        }
    }

    &__description {
        font-size: $font-size-md;
    }
}

@keyframes shimmer {
    0% {
        background-position: -468px 0;
    }
    100% {
        background-position: 468px 0;
    }
}

.skeleton {
    &__title {
        height: 40px;
        width: 70%;
        background: #eee;
        margin-bottom: 20px;
    }

    &__info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    &__line {
        height: 20px;
        background: #eee;

        &.short {
            width: 150px;
        }
    }

    &__image {
        height: 450px;
        width: 100%;
        background: #eee;
        margin-bottom: 30px;
    }

    &__text {
        height: 15px;
        width: 100%;
        background: #eee;
        margin-bottom: 10px;
    }

    div {
        background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
        background-size: 800px 104px;
        animation: shimmer 1.5s forwards infinite linear;
        border-radius: 4px;
    }
}
</style>
