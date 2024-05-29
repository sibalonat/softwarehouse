import { useForm } from '@formkit/inertia'
import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia'
import { computed, reactive, ref } from 'vue';


export const useFormAttributeStores = defineStore('form', () => {

    // state
    const form = useForm()
    const hiredBoolean = ref([]);
    const hiredSalesBoolean = ref([]);
    const showDialog = ref(false);
    const properties = reactive({
        model: null,
        boolean: null,
        webroute: null,
        props: null,
    });


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
                        showDialog.value = false;
                    },
                }
            );
        }
    };

    function setUpData(data) {
        hiredBoolean.value = data.data.map(item => item);
        hiredSalesBoolean.value = data.data.map(item => {
            return {
                hired: item.hired ? true : false,
            };
        });
    }

    // open dialog
    function openDialog(model, boolean, webroute, props) {
        properties.model = model;
        properties.boolean = boolean;
        properties.webroute = webroute;
        properties.props = props;
        showDialog.value = true;
    }

    function closeDialog() {
        showDialog.value = false;
        const item = hiredBoolean.value.find(item => item.id === properties.model.id);
        item.hired = !item.hired;
        setInitialValues();
    }

    function setInitialValues() {
        properties.model = null;
        properties.boolean = null;
        properties.webroute = null;
        properties.props = null;
    }


    return {
        showDialog,
        properties,
        hiredBoolean,
        hiredSalesBoolean,
        setUpData,
        sendRequest,
        openDialog,
        closeDialog,
        setInitialValues,
    }
})
