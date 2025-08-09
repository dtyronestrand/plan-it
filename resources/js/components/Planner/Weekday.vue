<template>
    <div v-for="view in weekView" :key="view.format('YYYY-MM-DD')" class="weekday">
        <div class="day-header">
            {{ view.format('dddd') }}
        </div>
        <div class="day-content">
            <p>{{ view.format('D') }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import {useDateState} from '../../composables/useDateState';
import dayjs from 'dayjs';
import {computed, watchEffect} from 'vue';

const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();

const weekView = computed(() => {
    const selectedDay = dayjs(`${selectedYear.value}-${selectedMonth.value + 1}-${selectedDate.value}`);
    const startOfWeek = selectedDay.startOf('week');
    
    return Array.from({ length: 7 }, (_, i) => startOfWeek.add(i, 'day'));
});

watchEffect(() => {
    console.log(weekView.value);
});
</script>

<style scoped>

</style>