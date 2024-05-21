import { usePage } from '@inertiajs/vue3'
import { defineStore } from 'pinia'
import { reactive, ref } from 'vue'
import anime from 'animejs'

export const useNavigationStore = defineStore('navigation', () => {

    // state
    const menu = ref([])
    const showingNavigationDropdown = ref(false)

    const showingSidebar = ref(false)
    const targets = ref(null)

    // global props inertia
    const auth = usePage().props.auth

    // menu items
    const logout = ref({
        title: 'Logout',
        icon: 'arrow-right-start-on-rectangle',
        route: 'logout',
        children: []
    })

    const nav_links = ref(auth.menu)
    nav_links.value.push(logout.value)

    // accordion data
    const accordion = reactive({
        count: 0,
        active: null,
    })

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
        accordion,
        nav_links,
        showingSidebar,
        showingNavigationDropdown,
        triggerShow,
        gameNameChange,
    }
})
