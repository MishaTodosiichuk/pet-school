<template>
    <div class="unfounded-block">
        <div class="unfounded-content">
            <h1 class="unfounded-title">
                404 - Сторінку не знайдено
            </h1>

            <p class="unfounded-text">
                На жаль, такої сторінки не існує або її було перенесено.
            </p>

            <RouterLink to="/" class="unfounded-link">
                <button
                    type="button"
                    class="el-button el-button--warning button-contacts"
                >
                    Перейти на головну
                </button>
            </RouterLink>
        </div>
    </div>
</template>

<style scoped lang="scss">
.unfounded-block {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    text-align: center;

    .unfounded-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: $space-4;
    }

    .unfounded-title {
        color: $color-gray-700;
        margin: 0;
    }

    .unfounded-text {
        font-size: $font-size-md;
        color: $color-gray-500;
        margin: 0;
    }

    .unfounded-link {
        text-decoration: none;
    }

    .button-contacts {
        width: 363px;
        height: 48px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 500;

        &.el-button {
            color: white !important;

            :deep(span) {
                color: white !important;
            }
        }
    }
}
</style>
