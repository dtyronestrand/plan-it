<template>
   
    <div class="bg-base-300"><Planner/></div>
   
</template>
<script setup lang="ts">
import Planner from '@/components/Planner/Index.vue'
import Default from '@/layouts/Default.vue'



defineOptions({
    layout: Default
})


</script>