<template>
    <div class="week-container bg-base-100 md:gap-4 md:grid md:grid-cols-6 md:grid-rows-9 md:items-start sm:flex sm:flex-row sm:flex-wrap sm:items-center ">
      <Weekday/>
      <Someday/>
    </div>
</template>

<script setup lang="ts">
import {useDateState} from '../../composables/useDateState';
import dayjs from 'dayjs';
import {computed, watchEffect} from 'vue';
import Someday from './Someday.vue';

const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();

const weekView = computed(() => {
    const selectedDay = dayjs(`${selectedYear.value}-${selectedMonth.value + 1}-${selectedDate.value}`);
    const startOfWeek = selectedDay.startOf('week');
    
    return Array.from({ length: 7 }, (_, i) => startOfWeek.add(i, 'day'));
});


</script>

<style scoped>

</style>