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
    condition: {
        type: Boolean,
        default: true,
    },
});

const classes = computed(() =>
    props.active
        ? 'items-center py-0.5 border-b-2 border-indigo-400 leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out flex items-center justify-between w-full'
        : 'flex items-center justify-between w-full group items-center py-1 border-b-2 border-transparent leading-5 text-slate-50 hover:text-slate-150 hover:border-gray-300 focus:outline-none focus:text-slate-150 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="[classes, condition ? 'font-normal' : 'font-light']">
        <slot />
    </Link>
</template>
