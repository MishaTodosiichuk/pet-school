<script setup lang="ts">
import {NewsItemType} from "@/types/news";

withDefaults(defineProps<{
    news: NewsItemType | null
}>(),{
    news: null
})
</script>

<template>
    <RouterLink v-if="news" class="news-item" :to="`news/${news.slug}`">
        <div class="news-item__image">
            <img
                loading="lazy"
                :src="news.image.url"
                :alt="news.image.alt"
                :width="news.image.width"
                :height="news.image.height">
        </div>

        <div class="news-item__info">
            <h3>
                {{ news.title }}
            </h3>
            <div class="news-item__info-description">
                {{ news.description }}
            </div>
            <span>
                {{ news.published }}
            </span>
        </div>
    </RouterLink>
</template>

<style scoped lang="scss">

.news-item {
    width: 100%;
    display: flex;
    gap: $space-4;
    transition: 0.3s ease;
    border-radius: 8px;

    @media (max-width: $breakpoint-sm) {
        flex-direction: column;
    }

    &:hover {
        transform: translate(2px, 2px);
        box-shadow: $shadow-lg;
        background: $color-gray-100;

        h3 {
            color: $color-accent;
            text-decoration: underline;
        }

        span {
            color: $color-accent;
        }
    }

    &__image {
        min-width: 281px;
        max-width: 281px;
        min-height: 187px;
        max-height: 187px;

        @media (max-width: $breakpoint-sm) {
            min-width: 100%;
            max-width: 100%;
            min-height: 100%;
            max-height: 100%;
        }
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
    }

    &__info {
        padding: $space-2 0;
        display: flex;
        flex-direction: column;
        gap: $space-3;
        font-family: $font-main;
        font-weight: normal;

        @media (max-width: $breakpoint-md) {
            gap: $space-2;
            padding: 0;
        }

        h3 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        &-description {
            font-size: $font-size-md;
            color: $color-gray-700;

            width: 95%;

            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;

            @media (max-width: $breakpoint-md) {
                -webkit-line-clamp: 3;
            }
        }

        span {
            font-size: $font-size-sm;
            color: $color-gray-500;
            font-style: italic;
            transition: 0.3s ease;
        }
    }
}
</style>
