<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);
const showing = ref(false);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<style>
    .password-wrapper {
        position: relative;
    }
    .password-input + span {
        cursor: pointer;
        font-size: 12px;
        letter-spacing: 1px;
        line-height: 1;
        position: absolute;
        right: 20px;
        text-transform: uppercase;
        top: 15px;
        z-index: 10;
    }
</style>

<template>
    <div class="password-wrapper">
        <input
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm password-input w-full"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            :type="showing ? 'text' : 'password'"
        />
        <span @click="showing = ! showing">{{ showing ? 'hide' : 'show' }}</span>
    </div>
</template>
