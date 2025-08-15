<template>
    <div
        v-for="(view, index) in weekView"
        :key="view.format('YYYY-MM-DD')"
        :class="`day-${index}`"
        class="px-10 text-base-content bg-base-100 weekday col-span-1 row-span-2 pb-10 pt-10 text-2xl"
    >
        <div class="grid grid-cols-2">
            <p class="text-lg">{{ view.format('dddd') }}</p>
            <p>{{ view.format('D') }}</p>
            <span v-if="index < 5" >
            <span v-if="page.props.tasks && page.props.tasks.length > 0" class="col-span-2">
            <span v-for="task in page.props.tasks" :key="task.id">
            <span v-if="task.due_date === view.format('YYYY-MM-DD')">
                <div role="button" class="col-span-2 mt-5 border-b border-base-content/10">{{ task.name }}</div>
                </span>
            </span>
            </span>
            <TaskInput :disabled="false"  :due="view.format('YYYY-MM-DD')" class="col-span-2 mt-5" />
            <span v-for ="i in (9-page.props.tasks.length-1)" :key="i" class="col-span-2 mt-5">
                <TaskInput :disabled="true" />
            </span>
            </span>
            <span v-else>
                      <span v-if="page.props.tasks && page.props.tasks.length > 0" class="col-span-2">
            <span v-for="task in page.props.tasks" :key="task.id">
            <span v-if="task.due_date === view.format('YYYY-MM-DD')">
                <div role="button"  class="col-span-2 mt-5 border-b border-base-content/10" :taskName="task" :disabled="true">{{ task.name }}</div>
                </span>
            </span>
            </span>
            <TaskInput :disabled="false" class="col-span-2 mt-5" />
            <span v-for ="i in (3-taskList[index].tasks.length-1)" :key="i" class="col-span-2 mt-5">
                <TaskInput :disabled="true" />
            </span>
            </span>
        </div>
    </div>
</template>

<script setup lang="ts">
import dayjs from 'dayjs';
import { computed, watchEffect } from 'vue';
import { useDateState } from '../../composables/useDateState';
import {usePage} from '@inertiajs/vue3';
import TaskInput from './TaskInput.vue';
interface Props {
    taskProps?: {
        name: string;
        due: string;
        completed: boolean;
        sub: string;
    };
}
const props = defineProps<Props>();
const page = usePage();
const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();

const weekView = computed(() => {
    const selectedDay = dayjs(`${selectedYear.value}-${selectedMonth.value + 1}-${selectedDate.value}`);
    const startOfWeek = selectedDay.startOf('week').add(1, 'day'); // Adjust to start on Monday

    return Array.from({ length: 7 }, (_, i) => startOfWeek.add(i, 'day'));
});

const taskList = computed(() => {
    return weekView.value.map(day => ({
        day: day.format('YYYY-MM-DD'),
        tasks: page.props.calendar.tasks.filter(task => task.due === day.format('YYYY-MM-DD'))
    }));
});

watchEffect(()=>{
    console.log(taskList.value);
})
</script>

<style scoped>
@reference "../../../css/app.css";

.day-5 {
    @apply row-span-1 mt-10;
    grid-column: 6;
    grid-row: 1;
}
.day-6 {
    @apply row-span-1;
    grid-column: 6;
    grid-row: 2;
}
</style>
