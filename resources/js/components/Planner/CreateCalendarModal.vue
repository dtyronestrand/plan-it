<template>
    <div v-if="createCalendar" class="fixed inset-0 flex h-screen w-full items-center justify-center bg-slate-800/75" @click.self="close">
        <div class="bg-base-1000 relative w-full max-w-2xl rounded-lg p-10 shadow-lg">
            <button aria-label="close" class="text-base-100 absolute right-0 top-0 mx-5 my-2 text-xl" @click.prevent="close">&times;</button>
            <div class="p-5">
                <h2 class="text-base-100 mb-4 text-2xl">Create a Calendar</h2>
            </div>
            <form class="text-base-100 flex flex-col" @submit.prevent="submit">
                <label for="name">Name:</label>
                <input type="text" v-model="form.name" id="name" required />
                <label for="description">Description:</label>

                <input type="text" v-model="form.description" id="description" />
                <label for="colorPicker">Color:</label>
                <input type="color" v-model="form.color" id="colorPicker" />
                <label for="is_default">Set as default:</label>
                <input type="checkbox" v-model="form.is_default" id="is_default" />
                <button
                    :disabled="form.hasErrors"
                    class="focus:shadow-outline hover:from-base-1000 text-base-100 mx-auto mt-10 w-[25%] rounded-lg border-slate-800 bg-gradient-to-b from-slate-900 to-white px-5 py-3 text-2xl font-bold leading-none focus:outline-none"
                    type="submit"
                >
                    Create
                </button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

interface Props {
    createCalendar: boolean;
}
defineProps<Props>();

const form = useForm({
    name: '',
    description: '',
    color: '',
    is_default: false,
    is_active: true,
});

const submit = () => {
    form.post(route('calendars.store'), {
        onFinish: () => {
            if (!form.hasErrors) {
                emit('close');
            }
        },
    });
};

function close() {
    emit('close');
}
</script>

<style scoped>
@reference "../../../css/app.css";

input {
    @apply border-base-300 mb-4 rounded border-b p-2;
}
</style>
