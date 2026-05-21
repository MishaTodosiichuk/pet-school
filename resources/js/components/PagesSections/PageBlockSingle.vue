<script setup lang="ts">
import { computed } from 'vue'
import type { PageBlockType } from '@/types/pageInfo'

const props = defineProps<{
    blocks: PageBlockType[]
}>()

const hasBlocks = computed(() => props.blocks.length > 0)

const singleBlock = computed(() => {
    return props.blocks.length === 1
        ? props.blocks[0]
        : null
})

const isPdf = computed(() => {
    return singleBlock.value?.filePath?.toLowerCase()?.endsWith('.pdf')
})
</script>

<template>
    <div class="page-blocks-single">
        <template v-if="hasBlocks && singleBlock">
            <div class="page-blocks__single-item">
                <div class="header-block">
                    <h2 v-if="singleBlock.title">
                        {{ singleBlock.title }}
                    </h2>

                    <span
                        v-if="singleBlock.published"
                        class="date"
                    >
                        {{ singleBlock.published }}
                    </span>
                </div>

                <div
                    v-if="singleBlock.text"
                    class="description"
                    v-html="singleBlock.text"
                />

                <div
                    v-if="singleBlock.filePath"
                    class="pdf-container"
                >
                    <template v-if="isPdf">
                        <iframe
                            :src="`${singleBlock.filePath}#toolbar=0`"
                            width="100%"
                            height="800"
                            frameborder="0"
                        />
                    </template>

                    <template v-else>
                        <a
                            :href="singleBlock.filePath"
                            target="_blank"
                            class="download-file"
                        >
                            Відкрити документ
                        </a>
                    </template>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="unfounded-block">
                <div class="unfounded-content">
                    <p>
                        Нам шкода, даних для даної сторінки не знайдено :(
                    </p>

                    <span>
                        Спробуйте звʼязатися з адміністрацією
                    </span>

                    <RouterLink to="/contacts">
                        <button
                            type="button"
                            class="el-button el-button--warning button-contacts"
                        >
                            Перейти на сторінку контактів
                        </button>
                    </RouterLink>
                </div>
            </div>
        </template>
    </div>
</template>

<style scoped lang="scss">
.header-block {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.date {
    font-size: $font-size-sm;
    color: $color-gray-500;
    font-style: italic;
}

.page-blocks__single-item {
    h2 {
        margin-bottom: $space-2;
    }

    .description {
        width: 95%;
        margin-bottom: $space-6;
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
                &:last-child { margin-bottom: 0; }
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
                background: $color-white;
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

.pdf-container {
    width: 100%;
    margin-top: $space-3;
    border-radius: 6px;
    overflow: hidden;
    background: #e4e4e7;
}

.download-file {
    display: inline-block;
    padding: $space-3;
    text-decoration: none;
}

.unfounded-block {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 300px;
    text-align: center;

    .unfounded-content {
        display: flex;
        flex-direction: column;
        gap: $space-4;
    }

    p {
        font-size: $font-size-xl;
        font-weight: 600;
        color: $color-gray-500;
    }

    span {
        font-size: $font-size-md;
        color: $color-gray-400;
    }

    .button-contacts {
        width: 363px;
        height: 48px;

        span {
            color: white !important;
        }
    }
}
</style>
