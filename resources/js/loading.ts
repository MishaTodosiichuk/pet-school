import {reactive, nextTick} from 'vue'

let counter = 0

interface LoadingState {
    active: boolean

    show: () => Promise<void>

    hide: () => void

    reset: () => void

    wrap: <T>(fn: () => Promise<T>) => Promise<T>
}

export const loading = reactive<LoadingState>({
    active: false,

    async show() {
        counter++

        this.active = true

        await nextTick()
    },

    hide() {
        counter--

        if (counter <= 0) {
            counter = 0
            this.active = false
        }
    },

    reset() {
        counter = 0
        this.active = false
    },

    async wrap<T>(fn: () => Promise<T>): Promise<T> {
        await this.show()

        try {
            return await fn()
        } finally {
            this.hide()
        }
    }
})
