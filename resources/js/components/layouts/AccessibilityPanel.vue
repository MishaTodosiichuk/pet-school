<script setup lang="ts">
import {useAccessibilityStore} from '@/stores/accessibilityStore';
import {watchEffect} from 'vue';

const store = useAccessibilityStore();

watchEffect(() => {
    if (store.isContrast) {
        document.body.classList.add('accessibility-contrast');
    } else {
        document.body.classList.remove('accessibility-contrast');
    }

    document.documentElement.style.fontSize = `${store.fontSize}%`;
});
</script>

<template>
    <div class="acc-panel">
        <div class="container-site">
            <div class="acc-controls">
                <span class="acc-label">Доступність:</span>

                <button
                    @click="store.toggleContrast()"
                    class="acc-btn"
                    :class="{ 'active': store.isContrast }"
                >
                    <i class="fas fa-adjust"></i>
                    {{ store.isContrast ? 'Звичайний вид' : 'Контраст' }}
                </button>

                <div class="acc-font-group">
                    <button @click="store.setFontSize(100)" class="acc-btn" :class="{active: store.fontSize === 100}">
                        A
                    </button>
                    <button @click="store.setFontSize(125)" class="acc-btn md"
                            :class="{active: store.fontSize === 125}">A
                    </button>
                    <button @click="store.setFontSize(150)" class="acc-btn lg"
                            :class="{active: store.fontSize === 150}">A
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.acc-panel {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 8px 0;
    font-family: sans-serif;
}

.acc-controls {
    display: flex;
    align-items: center;
    gap: 20px;
    justify-content: flex-end;
}

.acc-btn {
    padding: 4px 12px;
    border: 1px solid #adb5bd;
    background: white;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 5px;

    &.active {
        background: #212529;
        color: white;
        border-color: #212529;
    }

    &.md {
        font-size: 1.1rem;
    }

    &.lg {
        font-size: 1.3rem;
    }
}

.acc-font-group {
    display: flex;
    align-items: center;
    gap: $space-2;
}

.acc-label {
    font-weight: bold;
    font-size: $font-size-sm;
}
</style>
