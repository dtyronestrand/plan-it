<template>
    <div class="p-4 bg-gray-100 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">Selected Date</h3>
        <p>Year: {{ selectedYear }}</p>
        <p>Month: {{ selectedMonth + 1 }}</p>
        <p>Date: {{ selectedDate }}</p>
        <p>Full Date: {{ formattedDate }}</p>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useDateState } from '../composables/useDateState';

const { selectedYear, selectedMonth, selectedDate } = useDateState();

const formattedDate = computed(() => {
    return new Date(selectedYear.value, selectedMonth.value, selectedDate.value).toLocaleDateString();
});
</script>