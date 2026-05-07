<script setup>
import {onMounted, onUnmounted} from "vue";
import {useScheduleStore} from "@/stores/schedule.ts";
import {storeToRefs} from "pinia";

const scheduleStore = useScheduleStore()

const {schedule, activeLesson, activeBreak} = storeToRefs(scheduleStore);

let timer = null

onMounted(() => {
    scheduleStore.updateActiveSchedule()

    timer = setInterval(() => {
        scheduleStore.updateActiveSchedule()
    }, 30000)
})

onUnmounted(() => {
    clearInterval(timer)
})
</script>

<template>
    <section class="schedule">
        <header class="schedule__header">
            <h2>Розклад дзвінків</h2>
        </header>

        <table class="schedule__table">
            <thead class="visually-hidden">
            <tr>
                <th>№</th>
                <th>Початок</th>
                <th>Кінець</th>
                <th>Перерва</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="item in schedule"
                :key="item.number"
                :class="{ 'active': activeLesson === item.number }">
                <td>{{ item.number }}</td>
                <td>{{ item.timeStart }}</td>
                <td>{{ item.symbol }}</td>
                <td>{{ item.timeEnd }}</td>
                <td
                    class="time-break"
                    :class="{'active': activeBreak === item.number}">
                    <template v-if="item.timeBreak">
                        ({{ item.timeBreak }})
                    </template>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
</template>

<style scoped lang="scss">

.schedule {
    width: 100%;
    padding: $space-2 $space-4 $space-6;

    &__header {
        display: flex;
        justify-content: space-between;
        margin-bottom: $space-2;
        font-weight: bold;
    }
}

.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.active {
    color: red !important;
}

.schedule__table {
    width: 100%;
    border-collapse: collapse;

    tr {
        width: 100%;
        display: flex;
        gap: $space-2;
        padding: $space-1 0;
        border-radius: 4px;

        &:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    }

    td {
        width: 20%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: monospace;
    }

    .time-break {
        font-size: $font-size-sm;
        color: #666;
    }
}
</style>
