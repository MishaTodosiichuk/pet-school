<script setup lang="ts">

import {ArrowRight} from "@element-plus/icons-vue";
import {ref} from "vue";
import {MenuItemType} from "@/types/menu";

withDefaults(defineProps<{
    menu: MenuItemType | null,
    level?: number
}>(),{
    menu: null,
    level: 0
})

const show = ref(false)

const toggleSubmenu = () => {
    show.value = !show.value
}
const beforeEnter = (el: Element) => {
    const element = el as HTMLElement;
    element.style.height = '0'
    element.style.opacity = '0'
}

const enter = (el: Element) => {
    const element = el as HTMLElement;
    element.style.transition = 'height 0.3s ease, opacity 0.3s ease'
    element.style.height = el.scrollHeight + 'px'
    element.style.opacity = '1'

    setTimeout(() => {
        element.style.height = 'auto'
    }, 300)
}

const leave = (el: Element) => {
    const element = el as HTMLElement;
    element.style.height = el.scrollHeight + 'px'
    element.style.opacity = '1'

    requestAnimationFrame(() => {
        element.style.transition = 'height 0.3s ease, opacity 0.3s ease'
        element.style.height = '0'
        element.style.opacity = '0'
    })
}
</script>


<template>
    <template v-if="menu?.children?.length">
        <li
            :class="`sidebar-menu__list-item ${show ? 'active' : ''}`"
            :style="{ paddingLeft: `${level * 16}px` }"
            @click="toggleSubmenu"
        >
            <a href="#">
                {{ menu?.title }}
            </a>
            <el-icon>
                <ArrowRight/>
            </el-icon>
        </li>
        <Transition
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
        >
            <ul v-if="show && menu?.children?.length > 0" class="sidebar-menu__list">
                <MenuItemCard
                    v-for="item in menu.children"
                    :key="item.slug"
                    :menu="item"
                    :level="level + 1"
                />
            </ul>
        </Transition>
    </template>
    <template v-else>
        <li class="sidebar-menu__list-item"
            :style="{ paddingLeft: `${level * 16}px` }"
        >
            <a :href="menu?.slug">
                {{ menu?.title }}
            </a>
        </li>
    </template>
</template>

<style scoped lang="scss">

.sidebar-menu {
    &__list {
        &-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid $color-gray-600;
            cursor: pointer;
            font-family: $font-main;
            font-weight: normal;
            font-size: $font-size-md;

            a {
                margin: $space-2 0;
                transition: 0.3s ease;
            }

            i {
                transition: 0.3s ease;
            }

            &:hover {
                color: red;

                i {
                    color: red;
                    transform: rotate(90deg);
                }

                a {
                    color: red;
                    text-decoration: underline;
                    transform: translateX(4px);
                }
            }
        }

        .active {
            color: red;
            border-bottom: 1px solid red;

            i {
                color: red;
                transform: rotate(90deg);
            }

            a {
                color: red;
                text-decoration: underline;
            }
        }
    }
}
</style>
