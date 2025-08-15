<template>
    <div class="col-span-6 pb-10">
        <div class="grid grid-cols-3 gap-4">
            <h2 class="text-base-content col-span-3 pl-10 text-5xl">Someday</h2>
            <TaskInput />
            <TaskInput />
            <TaskInput />
                 <TaskInput />
            <TaskInput />
            <TaskInput />
                 <TaskInput />
            <TaskInput />
            <TaskInput />
        </div>
    </div>
</template>

<script setup lang="ts">
import TaskInput from './TaskInput.vue';
</script>

<style scoped></style>
