<script setup>
import { useNavigationStore } from '@/Stores/NavigationStore';
import { storeToRefs } from "pinia";

const props = defineProps({
    class: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:open"]);

const menu = useNavigationStore();
const { triggerShow } = menu
const { showingSidebar } = storeToRefs(menu);

</script>

<template>
    <button @click="() => triggerShow()"
    class="z-20 flex items-center justify-center w-12 h-12 p-2 lg:h-16 lg:w-16"
    :class="class">
        <div class="relative z-30 w-6 h-6 lg:h-8 lg:w-8 focus:outline-none">
            <div class="absolute block w-5 transform -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2 lg:w-7">
                <span
                    aria-hidden="true"
                    :class="!showingSidebar ? '-translate-y-1.5 lg:-translate-y-2' : 'rotate-45'"
                    class="absolute block h-0.5 w-5 lg:w-7 transform bg-white transition duration-500 ease-in-out dark:bg-white"
                />
                <span
                    aria-hidden="true"
                    class="absolute block h-0.5 w-5 lg:w-7 transform bg-white transition duration-500 ease-in-out dark:bg-white"
                    :class="showingSidebar ? 'opacity-0' : ''"
                />
                <span
                    aria-hidden="true"
                    :class="!showingSidebar ? 'translate-y-1.5 lg:translate-y-2' : '-rotate-45'"
                    class="absolute block h-0.5 w-5 lg:w-7 transform bg-white transition duration-500 ease-in-out dark:bg-white"
                />
            </div>
        </div>
    </button>
</template>
