<script setup lang="ts">
import { ref } from 'vue'

// Типізуємо пропси через TS
const props = defineProps<{
    fetchData: (page: number, isMore: boolean, range: any) => Promise<void>
}>()

const dateRange = ref<[Date, Date] | []>([])

const handleClick = async () => {
    // Передаємо значення фільтра
    await props.fetchData(1, false, dateRange.value)
}
</script>

<template>
    <section class="filter-container">
        <div class="filter-item">
            <el-date-picker
                v-model="dateRange"
                type="daterange"
                range-separator="-"
                start-placeholder="Від"
                end-placeholder="До"
                size="large"
                class="date-sorter"
                format="DD.MM.YYYY"
                value-format="YYYY-MM-DD"
            />
        </div>

        <button
            type="button"
            class="el-button el-button--warning filter-button"
            @click="handleClick"
        >
            <span>ОК</span>
        </button>
    </section>
</template>

<style scoped lang="scss">
.filter-container {
    display: flex;
    align-items: center;
    gap: $space-3;
    margin-bottom: $space-5;
    width: 100%;
    box-sizing: border-box;

    @media screen and (max-width: $breakpoint-md) {
        flex-direction: column;
        align-items: stretch;
        gap: $space-2;
    }
}

.filter-item {
    display: flex;
    flex: 0 1 auto;

    @media screen and (max-width: $breakpoint-md) {
        width: 100%;
    }
}

.date-sorter {
    flex-grow: 1;
    width: 350px !important;

    @media screen and (max-width: $breakpoint-md) {
        width: 100% !important;
    }
}

.filter-button {
    height: 40px;
    padding: 0 30px;
    font-family: $font-heading;
    font-weight: bold;

    @media screen and (max-width: $breakpoint-md) {
        width: 100%;
        margin-left: 0 !important;
    }
}

:deep(.el-range-editor.el-input__inner) {
    border-radius: 8px;
    width: 100% !important;
    box-sizing: border-box;
}

:deep(.el-range-separator) {
    flex: 0 0 20px;
    padding: 0 !important;
}

:deep(.el-range-input) {
    width: 100% !important;
}
</style>
