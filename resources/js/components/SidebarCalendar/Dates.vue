<template>
    <div class="w-full bg-slate-500 p-5 rounded-b-lg">
<div class="grid grid-cols-7 place-items-center gap-x-2 gap-y-4">
<div v-for="day in days" :key="day">
<span class="text-gray-50">{{ day }}</span>
</div>
<div v-for="date in calendarDates" :key="date.key" class="h-8 w-8 flex items-center justify-center">
<button class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold" :class="date.isCurrentMonth ? 'text-white' : 'text-gray-400'"><span>{{ date.day }}</span></button>
</div>
</div>

    </div>
</template>

<script setup lang="ts">
import {computed} from 'vue';
import dayjs from 'dayjs';
import { useDateState } from '../../composables/useDateState';

const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();
const days = [
    "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"
]

const calendarDates = computed(() => {
    const year = selectedYear.value;
    const month = selectedMonth.value;
    const firstDay = new Date(year, month, 1);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());
    
    const dates = [];
    for (let i = 0; i < 42; i++) {
        const currentDate = new Date(startDate);
        currentDate.setDate(startDate.getDate() + i);
        dates.push({
            day: currentDate.getDate(),
            isCurrentMonth: currentDate.getMonth() === month,
            key: `${currentDate.getFullYear()}-${currentDate.getMonth()}-${currentDate.getDate()}`
        });
    }
    return dates;
});
</script>

<style scoped>

</style>