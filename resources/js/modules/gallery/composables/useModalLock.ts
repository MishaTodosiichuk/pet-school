import { watch, onMounted, onUnmounted, type Ref } from 'vue';

export function useModalLock(isOpen: Ref<boolean>, onClose?: () => void) {
    const handleKeyDown = (e: KeyboardEvent) => {
        if (e.key === 'Escape' && isOpen.value) {
            onClose?.();
        }
    };

    watch(isOpen, (val) => {
        if (val) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }, { immediate: true });

    onMounted(() => {
        window.addEventListener('keydown', handleKeyDown);
    });

    onUnmounted(() => {
        document.body.style.overflow = '';
        window.removeEventListener('keydown', handleKeyDown);
    });
}
