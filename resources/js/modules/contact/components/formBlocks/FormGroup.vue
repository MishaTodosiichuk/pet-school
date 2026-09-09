<script setup lang="ts">

const model = defineModel<string>({default: ''})

withDefaults(defineProps<{
    id: string,
    type?: string,
    label: string,
    isRequired?: boolean,
    placeholder: string,
    errors?: string | string[]
}>(), {
    type: 'text',
    isRequired: false,
    errors: '',
})

</script>

<template>
    <div class="form-group" :class="{ 'has-error': errors }">
        <label :for="id">
            {{ label }} <span v-if="isRequired">*</span>
        </label>
        <input
            :type="type"
            :id="id"
            v-model="model"
            :placeholder="placeholder"
        >
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

    input {
        padding: $space-3;
        border: 1px solid $color-gray-300;
        border-radius: $space-2;
        font-family: inherit;
        outline: none;
        transition: border-color 0.3s;

        &:focus {
            border-color: $color-primary;
        }
    }

    &.has-error {
        input {
            border-color: $color-error;
        }

        .error-msg {
            color: $color-error;
            font-size: $font-size-sm;
        }
    }
}
</style>
