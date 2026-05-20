<script setup lang="ts">
import { ArrowRight } from '@element-plus/icons-vue'
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import type { MenuItemType } from '@/types/menu'

const props = withDefaults(defineProps<{
    menu: MenuItemType | null
    level?: number
}>(), {
    menu: null,
    level: 0
})

const route = useRoute()

const show = ref(false)

const activeSlug = computed(() => route.params.slug as string | undefined)

const hasChildren = computed(() => {
    return !!props.menu?.children?.length
})

const hasActiveChild = (item: MenuItemType | null): boolean => {
    if (!item || !activeSlug.value) {
        return false
    }

    if (item.slug === activeSlug.value) {
        return true
    }

    return item.children?.some(child => hasActiveChild(child)) ?? false
}

const isActive = computed(() => {
    return hasActiveChild(props.menu)
})

const checkAndExpandMenu = () => {
    if (hasChildren.value) {
        show.value = isActive.value
    }
}

watch(
    () => activeSlug.value,
    () => {
        checkAndExpandMenu()
    },
    { immediate: true }
)

const toggleSubmenu = () => {
    show.value = !show.value
}

const beforeEnter = (el: Element) => {
    const element = el as HTMLElement

    element.style.height = '0'
    element.style.opacity = '0'
    element.style.overflow = 'hidden'
}

const enter = (el: Element) => {
    const element = el as HTMLElement

    element.style.transition = 'height 0.3s ease, opacity 0.3s ease'
    element.style.height = `${element.scrollHeight}px`
    element.style.opacity = '1'

    setTimeout(() => {
        element.style.height = 'auto'
        element.style.overflow = ''
    }, 300)
}

const leave = (el: Element) => {
    const element = el as HTMLElement

    element.style.height = `${element.scrollHeight}px`
    element.style.opacity = '1'
    element.style.overflow = 'hidden'

    requestAnimationFrame(() => {
        element.style.transition = 'height 0.3s ease, opacity 0.3s ease'
        element.style.height = '0'
        element.style.opacity = '0'
    })
}
</script>


<template>
    <template v-if="hasChildren">
        <li
            class="sidebar-menu__list-item"
            :class="{ active: isActive }"
            :style="{ paddingLeft: `${level * 16}px` }"
        >
            <button
                type="button"
                class="sidebar-menu__button"
                @click="toggleSubmenu"
            >
                <span>{{ menu?.title }}</span>

                <el-icon :class="{ 'arrow-rotated': show }">
                    <ArrowRight />
                </el-icon>
            </button>
        </li>

        <Transition
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
        >
            <ul
                v-if="show"
                class="sidebar-menu__list"
            >
                <MenuItemCard
                    v-for="item in menu?.children"
                    :key="item.slug"
                    :menu="item"
                    :level="level + 1"
                />
            </ul>
        </Transition>
    </template>
    <template v-else>
        <li
            class="sidebar-menu__list-item"
            :class="{ active: activeSlug === menu?.slug }"
            :style="{ paddingLeft: `${level * 16}px` }"
        >
            <RouterLink :to="`/page/${menu?.slug}`">
                {{ menu?.title }}
            </RouterLink>
        </li>
    </template>
</template>

<style scoped lang="scss">

.sidebar-menu {
    &__list {
        list-style: none;
        padding: 0;
        margin: 0;

        &-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid $color-gray-600;
            cursor: pointer;
            font-family: $font-main;
            font-weight: normal;
            font-size: $font-size-md;
            color: inherit;

            a {
                display: block;
                padding: $space-2 0;
                transition: 0.3s ease;
                width: 100%;
                color: inherit;
                text-decoration: none;
            }

            &:hover {
                color: $color-accent;

                a {
                    color: $color-accent;
                    text-decoration: underline;
                    transform: translateX(4px);
                }

                i,
                .el-icon {
                    color: $color-accent;
                    transform: rotate(90deg);
                }
            }

            &.active {
                color: $color-accent;
                border-bottom: 1px solid $color-accent;

                a,
                .sidebar-menu__button {
                    color: $color-accent;
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
        padding: 0;
        margin: $space-2 0;
        border: none;
        background: transparent;
        color: inherit;
        font: inherit;
        cursor: pointer;
        text-align: left;
        transition: 0.3s ease;

        span {
            transition: 0.3s ease;
        }

        .el-icon {
            flex-shrink: 0;
            transition: 0.3s ease;
        }

        &:hover {
            color: $color-accent;
            text-decoration: underline;

            span {
                transform: translateX(4px);
            }
        }
    }
}

.arrow-rotated {
    color: $color-accent;
    transform: rotate(90deg);
}
</style>
