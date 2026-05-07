<script setup>
import TheHeader from "@/components/layouts/TheHeader.vue";
import TheSidebar from "@/components/layouts/TheSidebar.vue";
import TheMainContent from "@/components/layouts/TheMainContent.vue";
import TheFooter from "@/components/layouts/TheFooter.vue";
import BackToTop from "@/components/BackToTop.vue";
import FixedMainMenu from "@/components/Modals/FixedMainMenu.vue";
import SideMenuModal from "@/components/Modals/SideMenuModal.vue";
import AccessibilityPanel from "@/components/layouts/AccessibilityPanel.vue";
</script>

<template>
    <!--    <AccessibilityPanel />-->
    <TheHeader/>
    <main class="bg-image">
        <div class="container-site">
            <div class="content">
                <TheSidebar/>
                <TheMainContent/>
                <FixedMainMenu/>
                <SideMenuModal/>
            </div>
        </div>
        <BackToTop/>
    </main>
    <TheFooter/>
</template>

<style lang="scss">

*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    height: 100%;
}

body {
    background: $color-gray-100;
}

body.accessibility-contrast {
    filter: grayscale(100%) !important;
    background-color: white !important;
    color: black !important;

    *, *::before, *::after {
        background-color: white !important;
        color: black !important;
        border-color: black !important;
        background-image: none !important;
        box-shadow: none !important;
    }

    a, button {
        text-decoration: underline !important;
        border: 2px solid black !important;
        padding: 2px 5px;
    }

    .sidebar-menu__head, .sticky-menu {
        background-color: black !important;
        color: white !important;

        i, svg, .icon-path {
            fill: white !important;
            color: white !important;
        }
    }
}

h1 {
    position: relative;
    font-family: $font-heading;
    font-size: clamp(1.5rem, 0.8vw + 1.3rem, 2rem);
    color: $color-black;
    font-weight: bold;
}

h2 {
    position: relative;
    font-family: $font-heading;
    font-size: clamp(1.25rem, 0.4vw + 1.2rem, 1.5rem);
    color: $color-black;
    font-weight: bold;
}

h3 {
    position: relative;
    font-family: $font-heading;
    font-size: clamp(1.255rem, 0vw + 1.3rem, 1.25rem);
    color: $color-black;
    font-weight: bold;
    transition: 0.3s ease;
}

p {
    font-family: $font-main;
    font-size: clamp(1rem, 0.2vw + 1rem, 1.25rem);
    color: $color-gray-700;
    font-weight: normal;
    line-height: 1.6;
}

.phpdebugbar {
    display: none;
}

.heading-line {
    padding-bottom: $space-3;
    border-bottom: 3px solid $color-gray-100;
    border-radius: 2px;
    margin-bottom: $space-5;

    @media (max-width: $breakpoint-md) {
        border-bottom: 3px solid $color-gray-300;
    }

    &::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -3px;
        height: 3px;
        width: 33%;
        background: $color-accent;
        border-radius: 2px;

        @media (max-width: $breakpoint-md) {
            width: 20%;
        }
    }
}

.layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.content {
    padding: $space-8 0;
    display: flex;
    flex: 1;
    position: relative;

    @media (max-width: $breakpoint-md) {
        padding: $space-4 0;
    }
}

.container-site {
    width: 95%;
    max-width: 1440px;
    margin: 0 auto;

    @media (max-width: $breakpoint-xl) {
        width: auto;
        margin: 0 60px;
    }

    @media (max-width: $breakpoint-xl) {
        margin: 0 $space-5;
    }

    @media (max-width: $breakpoint-md) {
        margin: 0 $space-3;
    }
}

.main-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    background: $color-white;
    min-width: 0;
    padding-bottom: $space-20;

    @media (max-width: $breakpoint-lg) {
        border-radius: 4px;
    }

    @media (max-width: $breakpoint-md) {
        padding-bottom: 0;
    }

    &__block {
        padding: $space-4 $space-8;

        @media (max-width: $breakpoint-md) {
            padding: $space-2 $space-4;
        }
    }
}

.section {
    padding: $space-4 0;
}

.bg-image {
    background-image: url('/images/body/bg-image.jpeg');

    background-repeat: repeat-y;
    background-position: center top;

    background-size: contain;

    min-height: 100vh;
}

.mob {
    display: none !important;

    @media (max-width: $breakpoint-md) {
        display: block !important;
    }
}
</style>
