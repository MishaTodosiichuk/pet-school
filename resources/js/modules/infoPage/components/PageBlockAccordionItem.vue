<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount, nextTick, watch} from 'vue'
import {ArrowDown} from '@element-plus/icons-vue'
import type {PageBlockType} from '@/modules/infoPage/types'

const props = defineProps<{
    block: PageBlockType
    isOpened: boolean
}>()

const emit = defineEmits<{
    (e: 'toggle'): void
}>()

const textRef = ref<HTMLElement | null>(null)
const isExpandable = ref(false)

const checkTruncation = async () => {
    await nextTick()

    if (props.block.filePath) {
        isExpandable.value = true
        return
    }

    if (!textRef.value) {
        isExpandable.value = false
        return
    }

    const fontSize = parseFloat(getComputedStyle(textRef.value).fontSize) || 16
    const collapsedHeight = 4.2 * fontSize

    textRef.value.style.maxHeight = `${collapsedHeight}px`

    isExpandable.value = textRef.value.scrollHeight > collapsedHeight + 5
}

watch(
    () => props.isOpened,
    (opened) => {
        if (!textRef.value || !isExpandable.value) return

        const fontSize = parseFloat(getComputedStyle(textRef.value).fontSize) || 16
        const collapsedHeight = 4.2 * fontSize

        if (opened) {
            textRef.value.style.maxHeight = `${textRef.value.scrollHeight}px`
        } else {
            textRef.value.style.maxHeight = `${collapsedHeight}px`
        }
    }
)

const handleItemClick = () => {
    if (!isExpandable.value) return
    emit('toggle')
}

watch(
    () => [props.block.text, props.block.filePath],
    () => checkTruncation()
)

onMounted(() => {
    checkTruncation()
    window.addEventListener('resize', checkTruncation)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', checkTruncation)
})
</script>

<template>
    <div
        class="page-block-card"
        :class="{
            'is-opened': isOpened,
            'is-disabled': !isExpandable
        }"
        @click="handleItemClick"
    >
        <div class="page-block-card__header">
            <h3>{{ block.title }}</h3>

            <button
                v-if="isExpandable"
                type="button"
                class="accordion-arrow"
                :class="{ 'is-rotated': isOpened }"
                @click.stop="handleItemClick"
            >
                <el-icon :size="24">
                    <ArrowDown/>
                </el-icon>
            </button>
        </div>

        <div class="page-block-card__body">
            <div
                v-if="block.text"
                ref="textRef"
                class="page-block-card__text"
                :class="{
                    'is-expandable': isExpandable,
                    'is-collapsed': !isOpened && isExpandable
                }"
                v-html="block.text"
            />

            <div v-if="block.filePath && isOpened" class="pdf-container">
                <iframe
                    :src="`${block.filePath}#toolbar=0`"
                    width="100%"
                    height="500"
                />
            </div>
        </div>

        <div v-if="block.published" class="page-block-card__footer">
            <span class="date">{{ block.published }}</span>
        </div>
    </div>
</template>

<style scoped lang="scss">
.page-block-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: $space-4;
    border-radius: 12px;
    background-color: transparent;
    cursor: pointer;
    transition: background-color 0.2s ease;

    &:hover:not(.is-disabled) {
        background-color: $color-gray-100;

        h3,
        .accordion-arrow {
            color: $color-accent;
        }
    }

    &.is-opened {
        background-color: $color-gray-100;
    }

    &.is-disabled {
        cursor: default;
    }

    &__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: $space-3;

        h3 {
            margin: 0;
            font-size: $font-size-lg;
            font-weight: 700;
            color: $color-gray-700;
            transition: color 0.2s ease;
        }
    }

    &__body {
        margin-top: $space-2;
    }

    &__text {
        position: relative;
        font-size: $font-size-md;
        line-height: 1.6;
        color: $color-gray-700;
        overflow: hidden;
        overflow-wrap: break-word;
        word-break: break-word;

        transition: max-height 0.3s ease-out;

        :deep(p) {
            margin-bottom: $space-2;

            &:last-child {
                margin-bottom: 0;
            }
        }

        &.is-collapsed::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2em;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.95));
            pointer-events: none;
        }
    }

    &__footer {
        margin-top: $space-3;

        .date {
            font-size: $font-size-sm;
            font-style: italic;
            color: $color-gray-500;
        }
    }
}

.page-block-card:hover .page-block-card__text.is-collapsed::after,
.page-block-card.is-opened .page-block-card__text.is-collapsed::after {
    background: linear-gradient(to bottom, transparent, $color-gray-100);
}

.pdf-container {
    width: 100%;
    margin-top: $space-3;
    border-radius: 8px;
    overflow: hidden;
    background: $color-gray-200;
}

.accordion-arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    padding: 0;
    color: $color-gray-500;
    cursor: pointer;
    transition: transform 0.3s ease, color 0.2s ease;

    &.is-rotated {
        transform: rotate(180deg);
        color: $color-accent;
    }
}
</style>
