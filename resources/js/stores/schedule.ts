import { defineStore } from 'pinia'

import { ScheduleItem } from '@/types/schedule'

export const useScheduleStore = defineStore('schedule', {
    state: () => ({
        schedule: [
            { number: 1, timeStart: "08:30", symbol: "-", timeEnd: "09:15", timeBreak: 10 },
            { number: 2, timeStart: "09:25", symbol: "-", timeEnd: "10:10", timeBreak: 10 },
            { number: 3, timeStart: "10:20", symbol: "-", timeEnd: "11:05", timeBreak: 20 },
            { number: 4, timeStart: "11:25", symbol: "-", timeEnd: "12:10", timeBreak: 20 },
            { number: 5, timeStart: "12:30", symbol: "-", timeEnd: "13:15", timeBreak: 10 },
            { number: 6, timeStart: "13:25", symbol: "-", timeEnd: "14:10", timeBreak: 10 },
            { number: 7, timeStart: "14:20", symbol: "-", timeEnd: "15:05", timeBreak: null }
        ] as ScheduleItem[],
        activeLesson: null as number | null,
        activeBreak: null as number | null,
    }),

    getters: {},

    actions: {
        timeToMinutes (timeStr: string) {
            const [hours, minutes] = timeStr.split(':').map(Number)
            return hours * 60 + minutes
        },

        getNowMinutes () {
            const now = new Date()
            return now.getHours() * 60 + now.getMinutes()
        },
        updateActiveSchedule() {
            const nowTotal = this.getNowMinutes()

            this.activeLesson = null
            this.activeBreak = null

            this.schedule.forEach((item, index) => {
                const start = this.timeToMinutes(item.timeStart)
                const end = this.timeToMinutes(item.timeEnd)

                if (nowTotal >= start && nowTotal <= end) {
                    this.activeLesson = item.number
                    return
                }

                const nextLesson = this.schedule[index + 1]
                if (nextLesson) {
                    const nextStart = this.timeToMinutes(nextLesson.timeStart)
                    if (nowTotal > end && nowTotal < nextStart) {
                        this.activeBreak = item.number
                    }
                }
            })
        }
    },
});
