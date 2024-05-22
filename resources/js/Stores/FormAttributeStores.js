import { useForm } from '@formkit/inertia'
import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia'
import { computed } from 'vue';


export const useFormAttributeStores = defineStore('form', () => {

    // state
    const form = useForm()
    const hiredBoolean = ref([]);

    // computed
    const classesForToggle = computed(() => {
        return {
            container: 'inline-block rounded-full outline-none focus:ring focus:ring-neutral-100 focus:ring-opacity-0',
            toggle: 'flex h-5 w-12 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
            toggleOn: 'bg-neutral-500 border-neutral-100 justify-start text-white',
            toggleOff: 'bg-gray-200 border-gray-200 justify-end text-gray-700',
            toggleOnDisabled: 'bg-gray-300 border-gray-300 justify-start text-gray-400 cursor-not-allowed',
            toggleOffDisabled: 'bg-gray-200 border-gray-200 justify-end text-gray-400 cursor-not-allowed',
            handle: 'inline-block bg-white w-5 h-5 top-0 rounded-full absolute transition-all',
            handleOn: 'left-full transform -translate-x-full',
            handleOff: 'left-0',
            handleOnDisabled: 'bg-gray-100 left-full transform -translate-x-full',
            handleOffDisabled: 'bg-gray-100 left-0',
            label: 'text-center w-8 border-box whitespace-nowrap select-none',
        }
    });

    // methods
    const sendRequest = (model, boolean, webroute, props) => {
        let i = 0;
        i++;
        if (i > 0) {
            router.put(
                route(webroute, model),
                {
                    boolean,
                },
                {
                    onFinish: () => {
                        router.reload({ only: [props] });
                    },
                }
            );
        }
    };

    function setUpData(data) {
        hiredBoolean.value = data;
    }


    return {
        hiredBoolean,
        classesForToggle,
        setUpData,
        sendRequest,
    }
})
