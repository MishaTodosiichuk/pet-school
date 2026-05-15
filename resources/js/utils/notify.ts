import { ElNotification } from 'element-plus'
import { h } from 'vue'

export const notify = {
    success(message: string, title: string = 'Успішно') {
        ElNotification({
            title,
            message: h('span', { style: 'color: #10b981; font-weight: 500;' }, message),
            type: 'success',
            duration: 3000,
            position: 'bottom-right'
        })
    },

    error(message: string, title: string = 'Помилка') {
        ElNotification({
            title,
            message: h('span', { style: 'color: #f53434;' }, message),
            type: 'error',
            duration: 5000,
            position: 'bottom-right'
        })
    },

    info(message: string, title: string = 'Інформація') {
        ElNotification({
            title,
            message: h('span', { style: 'color: #0d61a2;' }, message),
            type: 'info',
            position: 'bottom-right'
        })
    }
}
