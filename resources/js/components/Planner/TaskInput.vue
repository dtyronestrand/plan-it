<template>
    
        <input
        :class="props.class"
        class="border-b border-slate-800 bg-transparent text-slate-50 focus:outline-none focus:border-slate-500"
        v-model="taskName"
        :disabled="!isEditable"
        type="text"
        @blur="handleBlur"
        @click="handleClick"
        >
    
</template>

<script setup lang="ts">
import { ref } from 'vue'
interface Props{
  class: string,
}
const props = defineProps<Props>();

const taskName = ref('')
const isEditable = ref(true)
const showModal = ref(false)
const handleBlur = () => {
  if (taskName.value.trim()) {
    // Save logic here
    console.log('Saving task:', taskName.value)
  }
}
const emit = defineEmits(['task-updated'])

const handleClick = () => {
if(!taskName.value.trim()) { 
isEditable.value = true
} else if(taskName.value.trim()) {
   showModal.value = true
  }else {
    isEditable.value = false
  }
}
</script>

<style scoped>

</style>