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
    const user = usePage().props.auth.user
    const game = usePage().props.auth.game

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

    function UpdateName() {
        router.reload({only: ['auth']})
    }


    return {
        user,
        game,
        menu,
        targets,
        showingSidebar,
        showingNavigationDropdown,
        UpdateName,
        triggerShow,
    }
})
