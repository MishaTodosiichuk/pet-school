<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount, nextTick, watch} from 'vue'
import type {PageBlockType} from '@/types/pageInfo'
import {ArrowDown} from '@element-plus/icons-vue'

const props = defineProps<{
    block: PageBlockType
    isOpened: boolean
}>()

const emit = defineEmits<{
    (e: 'toggle'): void
}>()

const textRef = ref<HTMLElement | null>(null)
const isExpandable = ref(false)

const checkTruncation = () => {
    if (props.block.filePath) {
        isExpandable.value = true
        return
    }

    if (!textRef.value) {
        isExpandable.value = false
        return
    }

    isExpandable.value = textRef.value.scrollHeight > textRef.value.clientHeight + 2
}

const handleResize = async () => {
    await nextTick()
    checkTruncation()
}

const handleItemClick = () => {
    if (!isExpandable.value) {
        return
    }

    emit('toggle')
}

watch(
    () => [props.block.text, props.block.filePath, props.isOpened],
    async () => {
        await nextTick()

        if (!props.isOpened) {
            checkTruncation()
        }
    }
)

onMounted(async () => {
    await nextTick()
    checkTruncation()

    window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize)
})

const beforeEnter = (el: Element) => {
    const element = el as HTMLElement

    element.style.height = '0'
    element.style.opacity = '0'
    element.style.overflow = 'hidden'
}

const enter = async (el: Element) => {
    const element = el as HTMLElement

    await nextTick()

    element.style.transition = 'height 0.35s ease, opacity 0.25s ease'
    element.style.height = `${element.scrollHeight}px`
    element.style.opacity = '1'

    const onTransitionEnd = () => {
        element.style.height = 'auto'
        element.style.overflow = ''
        element.removeEventListener('transitionend', onTransitionEnd)
    }

    element.addEventListener('transitionend', onTransitionEnd)
}

const beforeLeave = (el: Element) => {
    const element = el as HTMLElement

    element.style.height = `${element.scrollHeight}px`
    element.style.opacity = '1'
    element.style.overflow = 'hidden'
}

const leave = (el: Element) => {
    const element = el as HTMLElement

    requestAnimationFrame(() => {
        element.style.transition = 'height 0.3s ease, opacity 0.2s ease'
        element.style.height = '0'
        element.style.opacity = '0'
    })
}
</script>

<template>
    <div
        class="page-blocks__item"
        :class="{
            'page-blocks__item--active': isOpened,
            'page-blocks__item--disabled': !isExpandable
        }"
        @click="handleItemClick"
    >
        <div class="page-blocks__info">
            <div class="page-blocks__header">
                <h3>{{ block.title }}</h3>

                <button
                    v-if="isExpandable"
                    class="accordion-arrow"
                    :class="{ 'accordion-arrow--rotated': isOpened }"
                    type="button"
                    @click.stop="handleItemClick"
                >
                    <el-icon size="32">
                        <ArrowDown/>
                    </el-icon>
                </button>
            </div>

            <div
                v-if="!isOpened && block.text"
                ref="textRef"
                class="page-blocks__info-description"
                v-html="block.text"
            />

            <span
                v-if="block.published"
                class="date"
            >
                {{ block.published }}
            </span>

            <Transition
                @before-enter="beforeEnter"
                @enter="enter"
                @before-leave="beforeLeave"
                @leave="leave"
            >
                <div
                    v-if="isOpened"
                    class="page-blocks__collapse"
                    @click.stop
                >
                    <div class="page-blocks__full-content">
                        <div
                            v-if="block.text"
                            class="full-text"
                            v-html="block.text"
                        />

                        <div
                            v-if="block.filePath"
                            class="pdf-container"
                        >
                            <iframe
                                :src="`${block.filePath}#toolbar=0`"
                                width="100%"
                                height="600"
                                frameborder="0"
                            />
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped lang="scss">
.page-blocks {
    &__item {
        width: 100%;
        display: flex;
        border-radius: 8px;
        padding: $space-2;
        cursor: pointer;
        transition: background 0.3s ease, box-shadow 0.3s ease;

        &:not(.page-blocks__item--disabled):hover {
            box-shadow: $shadow-lg;
            background: $color-gray-100;

            h3,
            .date,
            .accordion-arrow {
                color: $color-accent;
            }
        }

        &--disabled {
            cursor: default;
        }

        &--active {
            background: $color-gray-100;
        }
    }

    &__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: $space-3;
        width: 100%;
    }

    &__info {
        width: 100%;
        padding: $space-2 0;
        display: flex;
        flex-direction: column;
        gap: $space-3;
        font-family: $font-main;
        font-weight: normal;

        h3 {
            width: 90%;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.3s ease;
        }

        &-description {
            width: 95%;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: $font-size-md;
            color: $color-gray-700;
            overflow-wrap: break-word;
            word-break: break-word;

            :deep(span) {
                overflow-wrap: break-word;
                word-break: break-word;
            }

            :deep(p) {
                margin: 0;
                padding: 0;
            }
        }
    }

    &__collapse {
        width: 100%;
        overflow: hidden;
        will-change: height, opacity;
    }

    &__full-content {
        padding: $space-3 0;
        display: flex;
        flex-direction: column;
        gap: $space-4;

        .full-text {
            font-size: $font-size-md;
            color: $color-gray-700;
            line-height: 1.6;
            overflow-wrap: break-word;
            word-break: break-word;

            :deep {
                span {
                    overflow-wrap: break-word;
                    word-break: break-word;
                }

                p {
                    margin-bottom: $space-3;

                    &:last-child {
                        margin-bottom: 0;
                    }
                }

                br {
                    display: block;
                    content: "";
                    margin-top: $space-1;
                }

                ul {
                    list-style-type: disc;
                    margin-left: $space-5;
                    margin-bottom: $space-4;
                    padding-left: $space-2;

                    li {
                        margin-bottom: $space-2;
                    }
                }

                ol {
                    list-style-type: decimal;
                    margin-left: $space-5;
                    margin-bottom: $space-4;
                    padding-left: $space-2;

                    li {
                        margin-bottom: $space-2;
                    }
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: $space-4 0;
                    font-size: $font-size-sm;
                    background: #ffffff;
                    border: 1px solid $color-gray-300;
                    border-radius: 4px;
                    overflow: hidden;

                    th, td {
                        border: 1px solid $color-gray-300;
                        padding: $space-3 $space-4;
                        text-align: left;
                        vertical-align: middle;
                    }

                    th {
                        background-color: $color-gray-100;
                        font-weight: 600;
                        color: $color-gray-700;
                    }

                    tr:nth-child(even) {
                        background-color: #fcfcfd;
                    }

                    tr:hover {
                        background-color: #f8fafc;
                    }
                }
            }
        }
    }
}

.accordion-arrow {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: none;
    background: none;
    color: $color-gray-500;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;

    &--rotated {
        color: $color-accent;
        transform: rotate(180deg);
    }
}

.date {
    font-size: $font-size-sm;
    color: $color-gray-500;
    font-style: italic;
    transition: color 0.3s ease;
}

.pdf-container {
    width: 100%;
    margin-top: $space-3;
    border-radius: 6px;
    overflow: hidden;
    background: #e4e4e7;
}
</style>
