<template>
    <div v-if="createCalendar" class="fixed inset-0 flex h-screen w-full items-center justify-center bg-base-100/40" @click.self="close">
        <div class="bg-base-300 relative w-full max-w-2xl rounded-4xl p-10 shadow-lg">
            <button aria-label="close" class="text-base-content absolute right-0 top-0 mx-5 my-2 text-xl" @click.prevent="close">&times;</button>
            <div class="p-5">
                <h2 class="text-base-content text-center text-5xl font-bold mb-4 ">Create a Calendar</h2>
            </div>
            <form class="text-base-content flex flex-col" @submit.prevent="submit">
                <label for="name">Name:</label>
                <input type="text" v-model="form.name" id="name" required />
                <label for="description">Description:</label>

                <input type="text" v-model="form.description" id="description" />
                <label for="colorPicker">Color:</label>
                <input type="color" v-model="form.color" id="colorPicker" />
                <div class="flex flex-row place-items-center gap-2">
                <label for="is_default">Set as default:</label>
                <input class="align-self-center" type="checkbox" v-model="form.is_default" id="is_default" />
                </div>
                <button
                    :disabled="form.hasErrors"
                    class="btn btn-primary mt-4 rounded-xl"
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
    @apply border-primary mb-4 rounded border-b p-2;
}
</style>
