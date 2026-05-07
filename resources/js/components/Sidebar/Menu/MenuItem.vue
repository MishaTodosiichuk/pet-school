<script setup>

import {ArrowRight} from "@element-plus/icons-vue";
import {ref} from "vue";

const props = defineProps({
    menu: {
        type: Object,
        required: true
    },
    level: {
        type: Number,
        default: 0
    }
})

const show = ref(false)

const toggleSubmenu = () => {
    show.value = !show.value
}
const beforeEnter = (el) => {
    el.style.height = '0'
    el.style.opacity = '0'
}

const enter = (el) => {
    el.style.transition = 'height 0.3s ease, opacity 0.3s ease'
    el.style.height = el.scrollHeight + 'px'
    el.style.opacity = '1'

    setTimeout(() => {
        el.style.height = 'auto'
    }, 300)
}

const leave = (el) => {
    el.style.height = el.scrollHeight + 'px'
    el.style.opacity = '1'

    requestAnimationFrame(() => {
        el.style.transition = 'height 0.3s ease, opacity 0.3s ease'
        el.style.height = '0'
        el.style.opacity = '0'
    })
}
</script>

<template>
    <template v-if="menu?.children?.length > 0">
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
                <MenuItem
                    v-for="item in menu.children"
                    :key="item.slug"
                    :menu="item"
                    :level="level + 1"/>
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
