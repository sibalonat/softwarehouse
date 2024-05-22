import { useForm } from '@formkit/inertia'
import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia'
import { computed, ref } from 'vue';


export const useFormAttributeStores = defineStore('form', () => {

    // state
    const form = useForm()
    const hiredBoolean = ref([]);


    // methods
    const sendRequest = (model, boolean, webroute, props) => {
        let i = 0;
        i++;
        if (i > 0) {
            router.put(
                route(webroute, model),
                {
                    hired: boolean,
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
        console.log(hiredBoolean.value);
    }


    return {
        hiredBoolean,
        setUpData,
        sendRequest,
    }
})
