<template>
    <div>
<ul class="flex flex-row justify-center menu bg-slate-700 text-slate-200 min-h-full w-80 p-4">
    <li><i-gg-chevron-left-o @click="modifyYear(-1)" style="color: var(--slate-200); font-size:3rem;"/></li>
    <li class="text-center text-5xl align-self-center ">{{ selectedYear }}</li>
    <li><i-gg-chevron-right-o @click="modifyYear(1)" style="color: var(--slate-200); font-size:3rem;"/></li>
    </ul>
    </div>
</template>

<script setup lang="ts">
import { useDateState } from '../../composables/useDateState';

const { selectedYear, setSelectedYear } = useDateState();

function modifyYear(v: number){
    setSelectedYear(selectedYear.value + v);
}
</script>

<style scoped>

</style>