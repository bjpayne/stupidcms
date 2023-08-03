<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'text-white bg-brand-green focus:outline-none transition duration-150 ease-in-out'
        : 'text-white focus:outline-none transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes" class="flex items-center px-3 py-5 text-xl font-medium leading-5 w-full">
        <slot />
    </Link>
</template>
