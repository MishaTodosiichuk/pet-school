import {ref, nextTick} from 'vue'

let counter = 0
const activeLoading = ref(false)

export const useLoading = () => {
    const showLoading = async () => {
        counter++
        activeLoading.value = true
        await nextTick()
    }

    const hideLoading = () => {
        counter--
        if (counter <= 0) {
            counter = 0
            activeLoading.value = false
        }
    }

    const resetLoading = () => {
        counter = 0
        activeLoading.value = false
    }

    const wrap = async <T>(fn: () => Promise<T>): Promise<T> => {
        await showLoading()
        try {
            return await fn()
        } finally {
            hideLoading()
        }
    }

    return {
        activeLoading,
        showLoading,
        hideLoading,
        resetLoading,
        wrap
    }
}
