<script setup lang="ts">
import NewsList from "@/components/News/NewsList.vue";

defineProps({
    withTitle: {
        type: Boolean,
        default: true
    },
    news: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <section class="section">
        <h2 v-if="withTitle" class="heading-line">Новини</h2>
        <NewsList :news="news"/>
        <RouterLink to="/news" v-if="withTitle">
            <button aria-disabled="false"
                    type="button"
                    class="el-button el-button--warning">
                <span class="">Переглянути усі</span>
            </button>
        </RouterLink>
    </section>
</template>

<style scoped lang="scss">

</style>
