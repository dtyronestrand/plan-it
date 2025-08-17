<template>
    <input
        :class="props.class"
        class="text-base-content focus:border-base-content border-b border-base-content/10 bg-transparent focus:outline-none"
        v-model="taskName"
        :disabled="props.disabled"
        :calendarId ="props.calendarId"
        
        :due="props.due"
        type="text"
        @blur="handleBlur"
     
    />
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { router , usePage} from '@inertiajs/vue3';
interface Props {
    taskName?: string;
    class?: string;
    disabled?: boolean;
    due?: string;
    completed?: boolean;
 
}
const props = defineProps<Props>();
const page = usePage();
const taskName = ref(props.taskName || '');

const calendarId = ref(page.props.calendar.id)
const user = ref(page.props.auth.user.id);
watch(
    () => [taskName.value, props.due, props.completed, props.calendarId],
    ([name, due, completed, calendarId]) => {
        console.log('Component values:', {
            taskName: name,
            due,
            completed,
            calendarId
        });
    },
    { immediate: true }
);

const showModal = ref(false);

const handleBlur = () => {
    if (taskName.value.trim()) {
     router.post(route('tasks.store'), {
            name: taskName.value,
            due_date: props.due,
            done: props.completed,
            calendar_id: calendarId.value,
            user_id: user.value
        }, {
            onSuccess: () => {
                taskName.value = '';
                router.reload();
            }
        });
   }
};



</script>

<style scoped></style>
