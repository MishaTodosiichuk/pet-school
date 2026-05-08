<script setup lang="ts">
import {MetaItemType} from '@/types/pagination'

const props = withDefaults(defineProps<{
    meta: MetaItemType | null
    fetchData: Function
}>(), {
    meta: null,
})
const handlePageChange = async (page: number) => {
    await props.fetchData(page, false)
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

const loadMore = async () => {
    if (!props.meta) return

    if (props.meta.current_page < props.meta.last_page) {
        await props.fetchData(props.meta.current_page + 1, true)
    }
}
</script>

<template>
    <section class="pagination-wrapper">
        <el-pagination
            v-if="meta && meta.total > meta.per_page"
            background
            layout="prev, pager, next"
            :current-page="meta.current_page"
            :page-size="meta.per_page"
            :total="meta.total"
            @current-change="handlePageChange"
        />

        <button
            v-if="meta && meta.current_page < meta.last_page"
            class="load-more-btn"
            @click="loadMore"
        >
            <span>Показати ще</span>
        </button>
    </section>
</template>
<style scoped lang="scss">
.pagination-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    margin-top: 2rem;
}

:deep(.el-pagination.is-background .el-pager li:not(.is-disabled).is-active) {
    background-color:$color-accent !important;
}

.load-more-btn {
    padding: 10px 25px;
    background-color: $color-accent;
    border: 2px solid $color-accent;
    color: $color-white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;

    &:hover {
        color: white;
        border-color: #bd7905;
        box-shadow: $shadow-lg;
    }

    &:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
}
</style>
