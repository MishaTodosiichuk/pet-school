<script setup lang="ts">
import {computed} from 'vue'

interface Props {
    size?: number | string
    bg?: string
    pathFill?: string
    alignItems?: string
    justifyContent?: string
}

const props = withDefaults(defineProps<Props>(), {
    size: 32,
    bg: '#000',
    pathFill: '#f59e0b',
    alignItems: 'center',
    justifyContent: 'space-around'
})

const gradientId = `nz-gradient-${Math.random().toString(36).slice(2)}`

const iconStyles = computed(() => ({
    width: `${props.size}px`,
    height: `${props.size}px`,
    '--nz-gradient': `url(#${gradientId})`
}))

const fontSizeStyle = computed(() => ({
    fontSize: `${Number(props.size) - 2}px`
}))
</script>

<template>
    <div
        class="social-block"
        :style="`align-items: ${alignItems}; justify-content: ${justifyContent}`"
    >
        <a
            href="https://www.instagram.com/vaslovivtsi.school/"
            target="_blank"
            class="social-link"
        >
            <i
                class="fab fa-instagram"
                :style="fontSizeStyle"
            ></i>
        </a>

        <a
            href="https://facebook.com"
            target="_blank"
            class="social-link"
        >
            <i
                class="fab fa-facebook"
                :style="fontSizeStyle"
            ></i>
        </a>

        <a
            href="https://nz.ua/school/wall?id=5561"
            target="_blank"
            class="social-link"
        >
            <div class="icon-wrapper" :style="iconStyles">
                <svg
                    :width="size"
                    :height="size"
                    viewBox="0 0 40 40"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <defs>
                        <linearGradient
                            :id="gradientId"
                            x1="-9.36905"
                            y1="47.2683"
                            x2="46.503"
                            y2="38.5508"
                            gradientUnits="userSpaceOnUse"
                        >
                            <stop stop-color="#1A76FF" offset="0"/>
                            <stop offset="1" stop-color="#FFEA96"/>
                        </linearGradient>
                    </defs>

                    <rect
                        class="bg-rect"
                        width="40"
                        height="40"
                        rx="12"
                        :style="{ fill: bg }"
                    />

                    <path
                        class="icon-path"
                        d="M28.5958 21.1585L29.8709 21.9202C29.9496 21.9671 30.0147 22.0335 30.0599 22.1129C30.1051 22.1924 30.1289 22.2821 30.1289 22.3734C30.1289 22.4647 30.1051 22.5545 30.0599 22.6339C30.0147 22.7133 29.9496 22.7797 29.8709 22.8266L20.0209 28.7123L10.1708 22.8266C10.0921 22.7797 10.027 22.7133 9.98182 22.6339C9.93661 22.5545 9.91284 22.4647 9.91284 22.3734V17.4608C9.91284 17.3695 9.93661 17.2798 9.98182 17.2003C10.027 17.1209 10.0921 17.0545 10.1708 17.0076L19.4745 11.4484C19.6395 11.3497 19.8284 11.2975 20.0209 11.2975C20.2134 11.2975 20.4022 11.3497 20.5672 11.4484H20.5662L29.8709 17.0076C29.9496 17.0545 30.0147 17.1209 30.0599 17.2003C30.1051 17.2798 30.1289 17.3695 30.1289 17.4608C30.1289 17.5521 30.1051 17.6419 30.0599 17.7213C30.0147 17.8007 29.9496 17.8671 29.8709 17.914L20.0209 23.7997L11.7678 18.8683V21.3508L20.0209 26.2824L28.5958 21.1585Z"
                        :style="{ fill: pathFill }"
                    />
                </svg>
            </div>
        </a>
    </div>
</template>

<style scoped lang="scss">
.social-block {
    display: flex;
    width: 100%;
}

.social-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #000;
}

i {
    transition: all 0.3s ease;
}

.fa-instagram {
    @media (max-width: $breakpoint-md) {
        background: radial-gradient(
                circle at 30% 107%,
                #fdf497 0%,
                #fdf497 5%,
                #fd5949 45%,
                #d6249f 60%,
                #285aeb 90%
        );

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    &:hover {
        transform: translateY(-3px);

        background: radial-gradient(
                circle at 30% 107%,
                #fdf497 0%,
                #fdf497 5%,
                #fd5949 45%,
                #d6249f 60%,
                #285aeb 90%
        );

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
}

.fa-facebook {
    @media (max-width: $breakpoint-md) {
        color: #0064E0;
    }

    &:hover {
        transform: translateY(-3px);
        color: #0064E0;
    }
}

.icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;

    svg {
        .bg-rect,
        .icon-path {
            transition: fill 0.4s ease;
        }
    }

    @media (max-width: $breakpoint-md) {
        svg {
            .bg-rect {
                fill: var(--nz-gradient) !important;
            }

            .icon-path {
                fill: #000 !important;
            }
        }
    }

    &:hover {
        transform: translateY(-3px);

        svg {
            .bg-rect {
                fill: var(--nz-gradient) !important;
            }

            .icon-path {
                fill: #000 !important;
            }
        }
    }
}
</style>
