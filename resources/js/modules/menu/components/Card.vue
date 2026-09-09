<script setup lang="ts">
import {ArrowRight} from '@element-plus/icons-vue'
import {computed, inject, watch, type Ref} from 'vue'
import {useRoute} from 'vue-router'
import {MenuType} from "@/modules/menu/types"
import {useCollapseAnimation} from "@/modules/menu/composables"

const props = withDefaults(defineProps<{
    menu: MenuType | null
    level?: number
}>(), {
    menu: null,
    level: 0
})

const route = useRoute()

const activeParentSlug = inject<Ref<string | null>>('activeParentSlug')
const toggleParent = inject<(slug: string) => void>('toggleParent')

const activeSlug = computed(() => route.params.slug as string | undefined)
const hasChildren = computed(() => !!props.menu?.children?.length)

const hasActiveChild = (item: MenuType | null): boolean => {
    if (!item || !activeSlug.value) return false
    if (item.slug === activeSlug.value) return true
    return item.children?.some(child => hasActiveChild(child)) ?? false
}

const isSelfActive = computed(() => props.menu?.slug === activeSlug.value)

const isParentOfActive = computed(() => hasChildren.value && hasActiveChild(props.menu))

const show = computed(() => {
    if (!props.menu || !hasChildren.value) return false
    return activeParentSlug?.value === props.menu.slug
})

watch(
    () => activeSlug.value,
    () => {
        if (hasChildren.value && isParentOfActive.value && props.menu?.slug) {
            if (activeParentSlug?.value !== props.menu.slug && toggleParent) {
                toggleParent(props.menu.slug)
            }
        }
    },
    {immediate: true}
)

const handleToggle = () => {
    if (props.menu?.slug && toggleParent) {
        toggleParent(props.menu.slug)
    }
}

const {beforeEnter, enter, leave} = useCollapseAnimation()
</script>

<template>
    <li
        v-if="menu"
        class="sidebar-menu__list-item"
        :class="{
            'is-expanded': show,
            'active-self': isSelfActive
        }"
    >
        <!-- БАТЬКІВСЬКИЙ ПУНКТ (КАТЕГОРІЯ) -->
        <template v-if="hasChildren">
            <button
                type="button"
                class="sidebar-menu__button"
                :style="{ paddingLeft: `${level * 16}px` }"
                @click="handleToggle"
            >
                <span>{{ menu.title }}</span>

                <el-icon :class="{ 'arrow-rotated': show }">
                    <ArrowRight/>
                </el-icon>
            </button>

            <Transition
                @before-enter="beforeEnter"
                @enter="enter"
                @leave="leave"
            >
                <ul
                    v-show="show"
                    class="sidebar-menu__list"
                >
                    <Card
                        v-for="item in menu.children"
                        :key="item.slug"
                        :menu="item"
                        :level="level + 1"
                    />
                </ul>
            </Transition>
        </template>

        <!-- ДИТИНА (ПОСИЛАННЯ) -->
        <template v-else>
            <RouterLink
                :to="`/page/${menu.slug}`"
                :style="{ paddingLeft: `${level * 16}px` }"
            >
                {{ menu.title }}
            </RouterLink>
        </template>
    </li>
</template>

<style scoped lang="scss">
.sidebar-menu {
    &__list {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;

        &-item {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            border-bottom: 1px solid $color-gray-600;
            font-family: $font-main;
            font-size: $font-size-md;
            color: $color-gray-700;

            a {
                display: block;
                padding-top: $space-2;
                padding-bottom: $space-2;
                padding-right: 0;
                transition: 0.3s ease;
                width: 100%;
                color: inherit;
                text-decoration: none;

                &:hover {
                    color: $color-accent;
                    text-decoration: underline;
                }
            }

            > .sidebar-menu__button:hover {
                color: $color-accent;
                text-decoration: underline;

                .el-icon {
                    color: $color-accent;
                }
            }

            &.is-expanded {
                > .sidebar-menu__button {
                    color: $color-accent;
                    font-weight: 600;

                    .el-icon {
                        color: $color-accent;
                    }
                }
            }

            &.active-self {
                > a {
                    color: $color-accent;
                    font-weight: 600;
                    text-decoration: underline;
                }
            }
        }
    }

    &__button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: $space-2;
        padding-top: $space-2;
        padding-bottom: $space-2;
        padding-right: 0;
        margin: 0;
        border: none;
        background: transparent;
        color: inherit;
        font: inherit;
        cursor: pointer;
        text-align: left;
        transition: 0.3s ease;

        .el-icon {
            flex-shrink: 0;
            transition: transform 0.3s ease, color 0.3s ease;
        }
    }
}

.arrow-rotated {
    transform: rotate(90deg);
}
</style>
