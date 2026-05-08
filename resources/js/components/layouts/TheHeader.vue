<script setup lang="ts">
import logoSrc from '/public/images/header/logo.png';
import otherLogoSrc from '/public/images/header/otherLogo.png';
</script>

<template>
    <header class="header">
        <div class="container-site">
            <div class="header-content">
                <img class="header-content__logo" :src="logoSrc" width="90" height="140"
                     alt="Logo">
                <div class="header-content__text">
                    Васловівський ЗЗСО І-ІІІ ступенів
                </div>
                <img class="header-content__other-logo" :src="otherLogoSrc" width="124"
                     height="124" alt="Other logo">
            </div>
        </div>
    </header>
</template>

<style scoped lang="scss">

.header {
    background: $color-gray-200;

    background-image: url('/images/header/header.jpg');

    background-repeat: no-repeat;
    background-position: center;

    background-size: cover;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: $space-4 0;

    @media (max-width: $breakpoint-md) {
        justify-content: center;
        height: 170px;
    }

    &__logo, &__other-logo {
        filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.5));

        @media (max-width: $breakpoint-md) {
            display: none;
        }
    }

    &__logo {
        width: 94px;
        height: auto;
    }

    &__other-logo {
        width: 124px;
        height: auto;
    }

    &__text {
        display: flex;
        align-items: center;
        font-family: $font-heading;
        font-size: clamp(1.25rem, 1.2vw + 1rem, 2rem);
        font-style: italic;
        color: $color-white;
        text-align: center;

        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8),
        -1px -1px 2px rgba(0, 0, 0, 0.8),
        1px -1px 2px rgba(0, 0, 0, 0.8),
        -1px 1px 2px rgba(0, 0, 0, 0.8),
        0px 0px 5px rgba(0, 0, 0, 0.5);

    }
}

</style>
