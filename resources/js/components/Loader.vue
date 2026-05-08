<script setup lang="ts">
import { loading } from '@/loading'
</script>

<template>
    <Teleport to="body">
        <div v-if="loading.active" class="loading-overlay">
            <div class="loading">
                <div class="loading__spinner"></div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped lang="scss">

.loading-overlay {
    position: fixed;
    top: 0;
    width: 100vw;
    height: 100vh;
    z-index: 10000;
    background-color: rgba(0, 0, 0, 0.5);
}

.loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: $space-10;
    gap: $space-3;
    color: $color-white;
    font-size: $font-size-sm;

    &__spinner {
        width: 82px;
        height: 82px;
        border: 2px solid $color-gray-100;
        border-top-color: $color-primary;
        border-radius: 50%;
        animation: spinner-spin 0.6s linear infinite;
    }
}

@keyframes spinner-spin {
    to { transform: rotate(360deg); }
}

</style>
