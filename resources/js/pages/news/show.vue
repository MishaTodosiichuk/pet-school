<script setup lang="ts">

import {useRoute} from "vue-router";
import {onMounted} from "vue";
import {useNewsStore} from "@/stores/newsStore";
import {storeToRefs} from "pinia";
import GridImages from "@/components/GridImages.vue";

const route = useRoute()

const newsStore = useNewsStore()

const {singleNews} = storeToRefs(newsStore)

const slug = route.params.slug as string

const share = async (
    type: 'facebook' | 'telegram' | 'viber' | 'print'
) => {
    const url = encodeURIComponent(window.location.href)
    const title = encodeURIComponent(singleNews.value?.title ?? '')

    if (type === 'facebook') {
        window.open(
            `https://www.facebook.com/sharer/sharer.php?u=${url}`,
            '_blank'
        )
    }

    if (type === 'telegram') {
        window.open(
            `https://t.me/share/url?url=${url}&text=${title}`,
            '_blank'
        )
    }

    if (type === 'viber') {
        window.open(
            `viber://forward?text=${title}%20${url}`,
            '_blank'
        )
    }

    if (type === 'print') {
        window.print()
    }
}

onMounted(async () => {
    await newsStore.getNewsBySlug(slug)

    if (singleNews.value) {
        await newsStore.incrementViews(singleNews.value.slug)
    }
})

</script>

<template>
    <div class="section">
        <div v-if="singleNews" class="news-page">
            <h1 class="heading-line">{{ singleNews?.title }}</h1>

            <section class="section news-page__info">
                <div>Дата: <span>{{ singleNews?.published }}</span></div>
                <div>Кількість переглядів: <span>{{ singleNews?.viewsCount }}</span></div>
                <div class="share">
                    <button type="button" @click="share('facebook')">
                        <i class="fab fa-facebook"></i>
                    </button>

                    <button type="button" @click="share('telegram')">
                        <i class="fab fa-telegram"></i>
                    </button>

                    <button type="button" @click="share('viber')">
                        <i class="fab fa-viber"></i>
                    </button>

                    <button type="button" @click="share('print')">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </section>

            <div class="hr"></div>

            <section class="section news-page__image">
                <img
                    :src="singleNews?.image?.url"
                    :alt="singleNews?.image?.alt"
                >
            </section>

            <div class="hr"></div>

            <section class="section news-page__description" v-html="singleNews?.description"></section>

            <div class="hr"></div>

            <section class="section">
                <h2 class="heading-line">Всі фотографії</h2>
                <GridImages :images="singleNews?.images"/>
            </section>
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
    </div>
</template>

<style scoped lang="scss">
.news-page {
    .hr {
        height: 1px;
        width: 100%;
        background: $color-gray-200;

        @media (max-width: $breakpoint-md) {
            margin: $space-3 auto;
            background: $color-gray-300;
        }
    }

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
