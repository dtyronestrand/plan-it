<template>
    <div class="bg-base-300"><Planner /></div>
    <LoginModal :showing="show" @close="show = false" />
</template>
<script setup lang="ts">
import LoginModal from '@/components/Auth/LoginModal.vue';
import Planner from '@/components/Planner/Index.vue';
import Default from '@/layouts/Default.vue';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

let show = ref(false);
const page = usePage();

defineOptions({
    layout: Default,
});

onMounted(() => {
    if (!page.props.auth.user) {
        show.value = true;
    }
});
</script>
