<template>
<div :class="{done: props.task.done}" class="col-span-2 flex justify-between group border-b border-base-content/10 cursor-pointer"><p @click="openModal(props.task)" role="button" >{{ props.task.name }} </p><Checkmark :checked="checkedValue" type="checkbox"   class="opacity-0 group-hover:opacity-100" @updateChecked="handleTaskStatus"/></div>
                <!-- Modal -->
                <div v-if="selectedTask && selectedTask.id === props.task.id" class="fixed inset-0 bg-base-300 bg-opacity-20 flex items-center justify-center z-50" @click="closeModal">
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
            
</template>

<script setup lang="ts">
import { ref, computed, defineEmits } from 'vue';
import {useDateState} from '../../composables/useDateState';
import Checkmark from './Checkmark.vue'; 
import  { QuillEditor } from '@vueup/vue-quill';
interface Props {
    task: {
        name: string,
        notes: string,
        sub_tasks: Array<string>,
        done: boolean,
        id: number,
        date: string
    }
};
const props = defineProps<Props>();

const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();
const selectedTask = ref(null);

const checkedValue = computed(() => props.task.done);
const handleTaskStatus = () =>{
const updatedTask = {...props.task, done: !props.task.done};
    updateTaskStatus(updatedTask);
}
const emit = defineEmits(['taskStatus']);
const updateTaskStatus =(task)=>{
    emit('taskStatus', task)
}

const openModal = (task) => {
    selectedTask.value = { ...task };
};

const closeModal = () => {
    selectedTask.value = null;
};

const addSubtask = () => {
    if (selectedTask.value) {
        selectedTask.value.sub_tasks = selectedTask.value.sub_tasks || [];
        selectedTask.value.sub_tasks.push('');
    }
};

const removeSubtask = (index) => {
    if (selectedTask.value && selectedTask.value.sub_tasks) {
        selectedTask.value.sub_tasks.splice(index, 1);
    }
};

const submitForm = () => {
    closeModal();
};



</script>

<style scoped>
.done{
    text-decoration: line-through;
    color: gray;
}
</style>