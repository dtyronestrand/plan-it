<template>
    <div v-if="showing" class="fixed inset-0 w-full h-screen flex items-center justify-center bg-slate-800/75" @click.self="close">
        <div class="relative w-full max-w-2xl bg-slate-500 shadow-lg rounded-lg p-10">
            <button aria-label="close" class="absolute top-0 right-0 text-xl text-slate-50 my-2 mx-5" @click.prevent="close">
                &times;
            </button>
            <div class="p-5">
            <h2 class="text-2xl text-slate-50 mb-4">Login</h2>
            <p class="text-slate-50 mb-6">Please login to access your calendars.</p>
            </div>
            <form class="text-slate-50 flex flex-col" @submit.prevent="submit">
                <label for="email">Email:</label>
                <input type="email" v-model="form.email" id="email" required>
                <label for="password">Password:</label>
                <input type="password" v-model="form.password" id="password" required>
                <p><Link class="text-sm" href="/register">No account? Register.</Link></p>
                <button class="text-2xl font-bold px-5 py-3 w-[25%] mt-10 mx-auto leading-none text-slate-200 border-slate-800 rounded-lg focus:outline-none focus:shadow-outline bg-gradient-to-b hover:from-slate-500 from-slate-900 to-white" type="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">

import { router , Link, useForm} from '@inertiajs/vue3'

const emit = defineEmits(['close'])

interface Props{
    showing: boolean
}
defineProps<Props>()

const form = useForm({
    email: '',
    password: '',
    remember: false
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => { form.reset('password', 'email'); emit('close'); }
    });
};

function close(){
    emit('close')
}

</script>

<style scoped>
@reference "../../css/app.css";

input{
    @apply border-b border-slate-950 p-2 mb-4 rounded;
}
</style>