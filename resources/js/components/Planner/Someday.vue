<template>
    <div class="col-span-6">
        <div class="grid grid-cols-3 gap-4">
            <h2 class="text-base-content col-span-1 mx-5 border-b-4 border-base-content text-5xl">Someday</h2>
            
            <div role="button" v-for="task in taskList" :key="task.id" class="col-span-3 mx-5" >
                <div @click="openModal(task)"  class="border-b cursor-pointer border-base-content/10 py-2">{{ task.name }}</div>
                   <div v-if="selectedTask && selectedTask.id === task.id" class="fixed inset-0 bg-base-300 bg-opacity-20 flex items-center justify-center z-50" @click="closeModal">
                    <div class="bg-base-100 p-6 rounded-lg max-w-md w-full mx-4" @click.stop>
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <input v-model="selectedTask.name" type="text" class="input input-bordered w-full" placeholder="Task Name" />
                            <div v-for="(subtask, subIndex) in selectedTask.sub_tasks" :key="subIndex" class="flex items-center">
                                <input v-model="subtask.name" type="text" class="input input-bordered w-full mr-2" placeholder="Subtask Name" />
                                <button @click.prevent="removeSubtask(subIndex)" class="btn btn-sm ">-</button>
                                </div>
                            <div>
                                <p class="mb-2">Add Subtask</p>
                                <button @click.prevent="addSubtask" class="btn btn-sm btn-success mb-2">+</button>
                                <div v-for="(sub, subIndex) in selectedTask.subtasks" :key="subIndex" class="flex items-center mb-2">
                                    <input v-model="sub.name" type="text" class="input input-bordered w-full mr-2" placeholder="Subtask Name" />
                                    <button @click.prevent="removeSubtask(subIndex)" class="btn btn-sm btn-error">-</button>
                                </div>
                            </div>
                            <div>
                                <p class="mb-2">Notes</p>
                                <QuillEditor theme="snow" v-model="selectedTask.notes" class="mb-2" />
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-success flex-1">Save</button>
                                <button @click="closeModal" type="button" class="btn btn-error">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                </div>
     
         
            <TaskInput :disabled="false" :due="null" :calendarId="page.props.calendar.id" />
            <span v-for="i in (8-taskList.length)" :key="i" class="col-span-3">
                <TaskInput :disabled="true" :due="null" :calendarId="page.props.calendar.id" />
</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import TaskInput from './TaskInput.vue';
import { usePage , useForm} from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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
