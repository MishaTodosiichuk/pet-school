<template>
    <section class="section">
        <slot/>
    </section>
</template>

<style scoped lang="scss">
.section {
    padding: $space-4 0;

    @media (max-width: $breakpoint-md) {
        padding: $space-2 0;
    }
}
</style>
