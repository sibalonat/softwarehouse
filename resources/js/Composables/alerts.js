import {ref} from "vue";
import {v4 as uuidv4} from "uuid";

const alerts = ref([]);
const changekey = ref(0);
const identifier = ref(0);

export default function useAlerts() {
    const removeAlert = (id) => {

        setTimeout(() => {
            alerts.value = alerts.value.filter(alert => alert.id !== id);
            changekey.value--;
        }, 2000);
    };

    const addAlert = (alert) => {
        changekey.value++;
        const id = uuidv4();
        alerts.value.push({
            id: id,
            ...alert
        });

        identifier.value = id;

        if (alerts.value.length > 5) {
            alerts.value = alerts.value.slice(1);
        }
    };

    return {
        alerts,
        identifier,
        changekey,
        addAlert,
        removeAlert
    }
}
