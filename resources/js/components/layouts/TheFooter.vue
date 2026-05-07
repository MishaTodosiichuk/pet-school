<script setup>
import {computed} from "vue";

import SocialNetworks from "@/components/SocialNetworks.vue";

const currentYear = computed(() => new Date().getFullYear());
</script>
<template>
    <footer class="footer">
        <div class="container-site">
            <div class="footer-section">
                <div class="footer-section__socials">
                    <SocialNetworks
                        pathFill="#2D4959FF"
                        size="28"
                        align-items="start"
                        justify-content="space-between"
                    />
                </div>
                <div class="footer-section__copyright">
                    Васловівський ЗЗСО І-ІІІ ступенів - 2025-{{currentYear}} © Весь контент доступний за ліцензією
                    <a href="https://creativecommons.org/licenses/by/4.0/deed.uk" target="_blank" rel="nofollow">Creative
                        Commons Attribution 4.0 International License</a>
                    , якщо не зазначено інше.
                </div>
                <div class="footer-section__developer">
                    <a href="http://t.me/MishaTodosiichuk" target="_blank" rel="nofollow">
                        Developer
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped lang="scss">
.footer {
    background: $color-deep-primary;
}

.footer-section {
    display: grid;
    grid-template-columns: 20% 60% 20%;
    padding: $space-4 0;
    color: $color-gray-400;
    font-family: $font-main;
    font-size: $font-size-sm;
    font-weight: normal;

    @media (max-width: $breakpoint-md) {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: $space-4;
    }

    &__socials {
        display: flex;
        padding-right: $space-10;

        @media (max-width: $breakpoint-md) {
            width: 100px;
            padding: 0;
            gap: $space-4;
        }

        :deep(.social-block) {
            align-items: start;
        }
    }

    &__copyright {
        text-align: center;

        a {
            color: $color-gray-300;
        }
    }

    &__developer {
        display: flex;
        justify-content: end;

        a {
            cursor: pointer;
            transition: 0.3s ease;
            &:hover {
                color: white;
            }
        }

    }
}
</style>
