export function useCollapseAnimation(duration = 300) {
    const beforeEnter = (el: Element) => {
        const element = el as HTMLElement
        element.style.height = '0px'
        element.style.opacity = '0'
        element.style.overflow = 'hidden'
        element.style.willChange = 'height, opacity'
    }

    const enter = (el: Element, done: () => void) => {
        const element = el as HTMLElement
        const height = element.scrollHeight

        element.style.transition = `height ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), opacity ${duration}ms ease`
        element.style.height = `${height}px`
        element.style.opacity = '1'

        const onTransitionEnd = (e: Event) => {
            if (e.target !== element) return
            element.style.height = 'auto'
            element.style.overflow = ''
            element.style.willChange = ''
            element.removeEventListener('transitionend', onTransitionEnd)
            done()
        }

        element.addEventListener('transitionend', onTransitionEnd)
    }

    const beforeLeave = (el: Element) => {
        const element = el as HTMLElement
        element.style.height = `${element.offsetHeight}px`
        element.style.opacity = '1'
        element.style.overflow = 'hidden'
        element.style.willChange = 'height, opacity'
    }

    const leave = (el: Element, done: () => void) => {
        const element = el as HTMLElement

        requestAnimationFrame(() => {
            element.style.transition = `height ${duration}ms cubic-bezier(0.4, 0, 0.2, 1), opacity ${duration}ms ease`
            element.style.height = '0px'
            element.style.opacity = '0'
        })

        const onTransitionEnd = (e: Event) => {
            if (e.target !== element) return
            element.style.willChange = ''
            element.removeEventListener('transitionend', onTransitionEnd)
            done()
        }

        element.addEventListener('transitionend', onTransitionEnd)
    }

    return {
        beforeEnter,
        enter,
        beforeLeave,
        leave
    }
}
