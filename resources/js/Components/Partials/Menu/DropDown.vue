<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const emit = defineEmits(['toggle']);

const props = defineProps({
    index: {
        type: Number,
        required: true,
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white',
    },
});

const closeOnEscape = (e) => {
    if (props.isOpen && e.key === 'Escape') {
        emit('toggle', props.index);
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        48: 'w-48',
    }[props.width.toString()];
});

</script>

<template>
    <div class="relative w-full h-full">
        <div @click="emit('toggle', index)" class="h-full">
            <slot name="trigger" />
        </div>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="isOpen"
                class="absolute z-50 -top-24 mt-2 rounded-md shadow-lg"
                :class="widthClass"
                @click.stop
            >
                <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
