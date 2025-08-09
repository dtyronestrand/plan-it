<template>
    <div class="drawer">
    <input id="my-drawer" type="checkbox" class="drawer-toggle"/>
    <div class="drawer-content">
    <header class=" bg-slate-600 text-slate-300 pb-10">
<nav class="px-10 grid grid-cols-2 gap-4 items-center">
    <label for="my-drawer" class="drawer-button text-7xl font-semibold">{{ month}}</label>
  <ul class="flex  flex-row gap-4 justify-self-center align-self-center"><li class="flex flex-row gap-2 items-center">
<div class="dropdown dropdown-bottom dropdown-center m-auto">
<div tabindex="0" role="button" class="bg-slate-800 rounded-full m-1 text-[2rem]"><p class="p-2">DS</p></div>

<div tabindex="0" class="dropdown-content menu text-slate-200 bg-slate-800 rounded-box z-1 w-52 p-5 shadow-sm">
<p class="pl-2">Settings</p>
<ul>
<li>Edit Profile</li>
</ul>
</div>
</div>
  </li>
  <i-gg-more-vertical-o style="color:var(--slate-200); font-size:2em;"/>
  <li><i-gg-chevron-left-o style="font-size:2rem; "/></li>
  <li><i-gg-chevron-right-o style="font-size:2rem;"/></li>
  </ul>
</nav>
    </header>
<main class="mx-10">
<slot/>
</main>
    </div>
    <div class="drawer-side">
    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
   <SidebarCalendar />
   </div>
    </div>
</template>
<script setup lang="ts">
import dayjs from 'dayjs';
import { ref } from 'vue';
import SidebarCalendar from '@/components/SidebarCalendar/index.vue';
const auth = {
    user: "none"
}

const month = ref(dayjs().format('MMMM YYYY'));
</script>
<style scoped>
div, [popover]{
    margin:0;
    padding:0;
    border:0;
}
#settings_anchor{
    anchor-name: --settings_anchor;
}
#settings{
    position-anchor: --settings_anchor;
    inset-block-start: anchor(--settings_anchor bottm);
    inset-inline-start: anchor(--settings_anchor left)
}
[popover]{
    opacity: 0;
    background: var(--color-slate-400);
    color: var(--color-slate-800);
    transform: scale(0.8);
    transition: opacity 300ms, transform 300ms;
    &:popover-open{
        opacity: 1;
        transform: scale(1);
    }
}
</style>