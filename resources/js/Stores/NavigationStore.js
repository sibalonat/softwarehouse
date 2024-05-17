import { router, usePage } from '@inertiajs/vue3'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import anime from 'animejs'

export const useNavigationStore = defineStore('navigation', () => {

    // state
    const menu = ref([])
    const showingNavigationDropdown = ref(false)

    const showingSidebar = ref(false)
    const targets = ref(null)

    // authenticated user
    const auth = usePage().props.auth

    // methods
    function triggerShow() {
        if (showingSidebar.value) {
                anime({
                    targets: targets.value,
                    opacity: [1, 0],
                    duration: 400,
                    easing: 'easeOutQuad',
                    complete() {
                        showingSidebar.value = false
                    }
                  });
        } else {
            anime({
                targets: targets.value,
                width: '100%',
                opacity: [0, 1],
                duration: 400,
                easing: 'easeOutQuad',
                direction: 'normal',
                complete() {
                    showingSidebar.value = true
                }
              });
        }
    }

    function gameNameChange(payload) {
        auth.game.name = payload
    }


    return {
        auth,
        menu,
        targets,
        showingSidebar,
        showingNavigationDropdown,
        triggerShow,
        gameNameChange,
    }
})
