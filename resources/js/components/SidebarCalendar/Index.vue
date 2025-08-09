<template>
    <div class="" v-bind="$attrs">
       <div class="flex flex-col gap-8 items-center justify-center bg-slate-800 text-slate-200 p-4">
    <Year/>
    </div>
<Month/>
    </div>
</template>

<script setup lang="ts">
import { useDateState } from '../../composables/useDateState';
</script>

<style scoped>

</style>