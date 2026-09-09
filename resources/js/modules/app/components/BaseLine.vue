<template>
    <div class="hr"></div>
</template>

<style scoped lang="scss">
.hr {
    height: 1px;
    width: 100%;
    background: $color-gray-200;

    @media (max-width: $breakpoint-md) {
        margin: $space-3 auto;
        background: $color-gray-300;
    }
}
</style>
