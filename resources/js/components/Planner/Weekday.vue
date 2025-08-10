<template>

        <div v-for="(view, index) in weekView" :key="view.format('YYYY-MM-DD')" :class="`day-${index}`" class="text-slate-50 pb-10 text-2xl m-auto col-span-1 row-span-2 pt-10 weekday">
      <div class="grid grid-cols-2">
            <p class="text-lg">   {{ view.format('dddd') }}</p> 
                <p>{{ view.format('D') }}</p>
                <span v-if="index < 5">
   <TaskInput class="col-span-2 mt-5"/>
   <TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/><TaskInput class="col-span-2 mt-5"/>
                </span>
                <span v-else>
                <TaskInput class="col-span-2 mt-5"/>
                <TaskInput class="col-span-2 mt-5"/>
                <TaskInput class="col-span-2 mt-5"/>
             
                </span>
                </div>
        </div>

</template>

<script setup lang="ts">
import {useDateState} from '../../composables/useDateState';
import dayjs from 'dayjs';
import {computed, watchEffect} from 'vue';

interface Props{
    taskProps:  {
        name: string,
        due: string, 
        completed: boolean,
        sub: string
    }
}
defineProps<Props>();

const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();

const weekView = computed(() => {
    const selectedDay = dayjs(`${selectedYear.value}-${selectedMonth.value + 1}-${selectedDate.value}`);
    const startOfWeek = selectedDay.startOf('week').add(1, 'day'); // Adjust to start on Monday
    
    return Array.from({ length: 7 }, (_, i) => startOfWeek.add(i, 'day'));
});

watchEffect(() => {
    console.log(weekView.value);
});
</script>

<style scoped>
@reference "../../../css/app.css";

.day-5{
 @apply mt-10 row-span-1;
 grid-column: 6;
 grid-row: 1;

}
.day-6{
 @apply row-span-1;
 grid-column: 6;
 grid-row: 2;
}
</style>