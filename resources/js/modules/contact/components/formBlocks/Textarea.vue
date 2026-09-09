<script setup lang="ts">
import {computed} from "vue"

const model = defineModel<string>({default: ''})

withDefaults(defineProps<{
    errors?: string | string[]
    maxLength?: number
}>(), {
    error: [],
    maxLength: 2000
})

const countChar = computed(() => model.value.length)
</script>

<template>
    <div class="form-group" :class="{ 'has-error': error }">
        <label for="message">Текст повідомлення <span>*</span></label>

        <div class="textarea-wrapper">
            <textarea
                id="message"
                v-model="model"
                placeholder="Ваше повідомлення..."
                :maxlength="maxLength"
            ></textarea>

            <div
                class="char-counter"
                :class="{ 'at-limit': countChar >= maxLength }"
            >
                {{ countChar }} / {{ maxLength }}
            </div>
        </div>

        <template v-if="errors">
            <span v-for="error in errors" class="error-msg">
                    {{ error }}
                </span>
        </template>
    </div>
</template>

<style scoped lang="scss">
.form-group {
    display: flex;
    flex-direction: column;
    gap: $space-1;

    label {
        color: $color-gray-700;
        font-weight: 500;

        span {
            color: $color-error;
        }
    }

    textarea {
        padding: $space-3;
        border: 1px solid $color-gray-300;
        border-radius: $space-2;
        font-family: inherit;
        outline: none;
        transition: border-color 0.3s;
        min-height: 120px;

        &:focus {
            border-color: $color-primary;
        }
    }

    .textarea-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;

        textarea {
            padding-bottom: $space-8;
        }

        .char-counter {
            position: absolute;
            bottom: $space-2;
            right: $space-3;
            font-size: $font-size-sm;
            font-family: 'Instrument Sans', sans-serif;
            color: $color-gray-500;
            pointer-events: none;
            transition: color 0.3s ease;

            &.at-limit {
                color: $color-error;
                font-weight: 600;
            }
        }
    }

    &.has-error {
        .textarea-wrapper textarea {
            border-color: $color-error;
        }

        .error-msg {
            color: $color-error;
            font-size: $font-size-sm;
        }
    }
}
</style>
