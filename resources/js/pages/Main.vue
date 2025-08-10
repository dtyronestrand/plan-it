<template>
   
    <div class="bg-slate-950"><Planner/></div>
    <LoginModal :showing="show" @close="show = false"/>
</template>
<script setup lang="ts">
import Planner from '@/components/Planner/Index.vue'
import Default from '@/layouts/Default.vue'
import LoginModal from '@/components/Auth/LoginModal.vue'
import {onMounted, ref} from 'vue'
import {usePage} from '@inertiajs/vue3'

let show = ref(false)
const page = usePage()

defineOptions({
    layout: Default
})

onMounted(() => {
    if(!page.props.auth.user){
        show.value = true
    }
})
</script>