<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useNavigationStore } from '@/Stores/NavigationStore';
import { router, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const game = usePage().props.auth.game;
const navigation = useNavigationStore();
const { gameNameChange } = navigation;
// form constructor
const form = useForm({
    name: game.name,
});
// methods
const updateGameName = () => {
    form.patch(route('game.updateName', game), {
        preserveScroll: true,
        onSuccess: () => {
            gameNameChange(form.name);
        },
    });
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Game</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's Game information.
            </p>
        </header>

        <form @submit.prevent="updateGameName" class="mt-6 space-y-6">
            <div>
                <InputLabel for="game_name" value="Name" />

                <TextInput
                    id="game_name"
                    type="text"
                    class="block w-full mt-1"
                    v-model="form.name"
                    autofocus
                    autocomplete="game_name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
