<template>
<div v-for="(month, index) in months" :key="month.id" 
     :class="{'mt-5': index !== 0}" 
     class="bg-blue-900 text-slate-200 p-4 w-full">
    {{ month.name }}
    <Dates/>
</div>
</template>

<script setup lang="ts">
import Dates from './dates.vue';
import { useDateState } from '../../composables/useDateState';

const { selectedYear } = useDateState();

const months = [
  { id: 0, name: 'January' },
  { id: 1, name: 'February' },
  { id: 2, name: 'March' },
  { id: 3, name: 'April' },
  { id: 4, name: 'May' },
  { id: 5, name: 'June' },
  { id: 6, name: 'July' },
  { id: 7, name: 'August' },
  { id: 8, name: 'September' },
  { id: 9, name: 'October' },
  { id: 10, name: 'November' },
  { id: 11, name: 'December' }
];</script>

<style scoped>

</style>