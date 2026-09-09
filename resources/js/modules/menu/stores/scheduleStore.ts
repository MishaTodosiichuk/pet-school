import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { ScheduleType } from "@/modules/menu/types"
import {getNowMinutes, timeToMinutes} from "@/modules/menu/composables";

export const useScheduleStore = defineStore('schedule', () => {
    const schedule = ref<ScheduleType[]>([
        { number: 1, timeStart: "08:30", symbol: "-", timeEnd: "09:15", timeBreak: 10 },
        { number: 2, timeStart: "09:25", symbol: "-", timeEnd: "10:10", timeBreak: 20 },
        { number: 3, timeStart: "10:30", symbol: "-", timeEnd: "11:15", timeBreak: 10 },
        { number: 4, timeStart: "11:25", symbol: "-", timeEnd: "12:10", timeBreak: 10 },
        { number: 5, timeStart: "12:20", symbol: "-", timeEnd: "13:05", timeBreak: 10 },
        { number: 6, timeStart: "13:15", symbol: "-", timeEnd: "14:00", timeBreak: 10 },
        { number: 7, timeStart: "14:10", symbol: "-", timeEnd: "14:55", timeBreak: null }
    ])

    const activeLesson = ref<number | null>(null)
    const activeBreak = ref<number | null>(null)

    const updateActiveSchedule = () => {
        const nowTotal = getNowMinutes()

        activeLesson.value = null
        activeBreak.value = null

        for (let i = 0; i < schedule.value.length; i++) {
            const item = schedule.value[i]
            const start = timeToMinutes(item.timeStart)
            const end = timeToMinutes(item.timeEnd)

            if (nowTotal >= start && nowTotal <= end) {
                activeLesson.value = item.number
                break
            }

            if (item.timeBreak) {
                const breakEnd = end + item.timeBreak
                if (nowTotal > end && nowTotal < breakEnd) {
                    activeBreak.value = item.number
                    break
                }
            }
        }
    }

    return {
        schedule,
        activeLesson,
        activeBreak,
        updateActiveSchedule
    }
})
