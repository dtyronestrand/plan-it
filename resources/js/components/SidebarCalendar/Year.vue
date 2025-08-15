<template>
    <div>
        <ul class="menu text-base-100 flex min-h-full w-80 flex-row justify-center bg-primary p-4">
            <li><i-gg-chevron-left-o @click="modifyYear(-1)" style="color: var(--color-primary-content); font-size: 3rem" /></li>
            <li class="align-self-center text-center text-5xl text-primary-content" >{{ selectedYear }}</li>
            <li><i-gg-chevron-right-o @click="modifyYear(1)" style="color: var(--color-primary-content); font-size: 3rem" /></li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import dayjs from 'dayjs';
import { useDateState } from '../../composables/useDateState';

let currentYear = dayjs().year();
const { selectedYear, setSelectedYear } = useDateState();
setSelectedYear(currentYear);

function modifyYear(v: number) {
    setSelectedYear(selectedYear.value + v);
}
</script>

<style scoped></style>
