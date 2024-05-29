<template>
    <Teleport to="body">
        <div v-if="alerts.length" id="toast-success" class="absolute flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 -translate-x-1/2 bg-white rounded-lg shadow top-1/2 left-1/2 dark:text-gray-400 dark:bg-gray-800" role="alert">

            <div class="text-sm font-normal ms-3 flex flex-col py-4" v-for="alert in alerts" :key="alert.id">
                <p class="text-center">
                    {{ alert.message }}.
                </p>
                <button
                @click="restartGame"
                class="bg-audostrade w-2/3 mx-auto rounded-md py-1 px-1 mt-5 text-slate-50">
                    Restart game
                </button>

            </div>
            <button @click="removeAlert(identifier)" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </Teleport>
</template>

<script setup>
import {watch} from "vue";
import useAlerts from "@/Composables/alerts";
import { router } from "@inertiajs/vue3";
import { onMounted } from "vue";

const prop = defineProps({
    alert: Object,
});
const {addAlert, removeAlert, alerts, identifier} = useAlerts();

// methods
const restartGame = () => {
    router.get(route('restart-game'));
    removeAlert(identifier.value);
}

onMounted(() => {
    console.log(prop.alert);

});


watch(() => prop.alert, (newVal) => {
    if (newVal) {
        addAlert(newVal);
    }
});
</script>
