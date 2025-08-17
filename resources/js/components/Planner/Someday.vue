<template>
    <div class="col-span-6">
        <div class="grid grid-cols-3 gap-4">
            <h2 class="text-base-content col-span-3 mx-5 border-b-4 border-base-content text-5xl">Someday</h2>
            <div role="button" v-for="task in taskList" :key="task.id" class="col-span-1 row-start-2 mx-5" >
        <Task :task="task" @taskStatus="handleTaskStatus"/>
            </div>
            <TaskInput class="col-span-1" :disabled="false" :due="null" :calendarId="page.props.calendar.id" />
            <span v-for="i in (8-taskList.length)" :key="i" class="col-span-3">
                <TaskInput :disabled="true" :due="null" :calendarId="page.props.calendar.id" />
</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import TaskInput from './TaskInput.vue';
import { usePage , useForm, router} from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Task from './Task.vue';
const page = usePage();

const taskList = computed(() => {
    return page.props.tasks.filter(task => task.due_date === null || task.due_date === '');
});
const selectedTask = ref(null);

const form = useForm({
    name: '',
    due_date: '',
    done: false,
    notes: '',
    subtasks: [],
    user_id: page.props.auth.user.id,
    calendar_id: page.props.calendar.id
});
const handleTaskStatus= (updatedTask) => {
    console.log('handleTaskStatus called with:', updatedTask);
    router.put(
        `/tasks/${updatedTask.id}`,
        {
            id: updatedTask.id,
            name: updatedTask.name,
            due_date: updatedTask.due_date,
            notes: updatedTask.notes,
            subtasks: updatedTask.subtasks,
            user_id: page.props.auth.user.id,
            calendar_id: page.props.calendar.id,
            done: updatedTask.done 
        },
        {
            onSuccess: () => {
                router.reload();
            },
            onError: () => {
                // Handle error
            }
        }
    );
};
const submitForm = () => {
    if (selectedTask.value) {
        form.name = selectedTask.value.name;
        form.due_date = selectedTask.value.due_date;
        form.subtasks = Array.isArray(selectedTask.value.subtasks) ? selectedTask.value.subtasks : [];
        form.user_id = page.props.auth.user.id;
        form.calendar_id = page.props.calendar.id;
        
        form.put(`/tasks/${selectedTask.value.id}`);
    }
};

const openModal = (task) => {
    selectedTask.value = { ...task, subtasks: task.subtasks || [] };
};
const closeModal = () => {
    selectedTask.value = null;
};

const addSubtask = () => {
    if (selectedTask.value) {
        selectedTask.value.subtasks.push({ name: '', done: false });// Add a new subtask with default values
    }
};

const removeSubtask = (index: number) => {
    if (selectedTask.value) {
        selectedTask.value.subtasks.splice(index, 1);
    }
};
</script>

<style scoped></style>
