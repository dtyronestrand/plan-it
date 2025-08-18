<template>
    <div class="drawer">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <header class="bg-base-200 pb-10 text-base-content">
                <nav class="grid grid-cols-3 items-center justify-center gap-4 px-10 pt-10">
                    <label for="my-drawer" class="drawer-button text-7xl font-semibold">{{ month }}</label>
                    <div class="align-self-center flex justify-self-center">
                        <input ref="calendarInput" type="text" name="calendarName" v-model="calendarName" :readonly="!isEditable" @click="handleClick" @blur="handleBlur" v-if="$page.props.calendar" class="text-4xl font-semibold  text-center focus:border focus:border-base-content focus:background-base-300 focus:text-base-content" :class="{ 'cursor-pointer': !isEditable, 'cursor-text': isEditable }" :key="$page.props.calendar.id"/>
                        <h1 v-else class="text-4xl font-semibold">Calendar</h1>
                    </div>
                    <ul class="align-self-center flex flex-row gap-4 justify-self-center">
                        <li class="flex flex-row items-center gap-2">
                            <div class="dropdown dropdown-bottom dropdown-center m-auto">
                                <div tabindex="0" role="button" class="rounded-[50%] w-15 h-15 bg-base-100 text-[2rem]">
                                    <p class="p-2 text-base-content place-self-center justify-self-center">{{ initials }}</p>
                                </div>
                                <div tabindex="0" class="dropdown-content pl-5 pb-5 menu rounded-box z-1 text-primary-content w-full min-w-md bg-primary shadow-sm">
                                    <figure v-if="$page.props.auth.user.avatar"  class="flex items-center gap-2">
                                        <img  :src="$page.props.auth.user.avatar" alt="Avatar" class="h-10 w-10 rounded-full"/>
                                        <figcaption class="text-lg font-semibold">{{ $page.props.auth.user.name }}</figcaption>
                                        </figure>
                                        <div v-else class="flex m-5 mt-5 text-xl text-center mx-auto items-center gap-2 rounded-[50%] justify-center h-15 w-15 border-4 border-accent">{{ initials }}</div>
                                        <div class="mx-auto">{{$page.props.auth.user.name}}</div>
                                        <div class="grid grid-cols-2 justify-between gap-2 mb-5">
                                        <div class="text-center">
                                        <label for="select-calendar" class="text-sm">Select Calendar:</label>
                                        <select id="select-calendar" v-model="selectedCalendarId" @change="updateCalendar" class="select select-bordered select-sm w-full max-w-xs">
                                            <option v-for="calendar in $page.props.auth.user.calendars" :key="calendar.id" :value="calendar.id">{{ calendar.name }}</option>
                                        </select>
                                        </div>
                                        <div><button type="button">Calendar Settings</button></div>
                                        </div>
                                    <hr />
                                    <ul>
                                        <li>Edit Profile</li>
                                        <li v-if="$page.props.auth.user.calendars.length > 1">
                                            <p>Switch Calendars</p>
                                  
                                        </li>
                                        <li><button type="button" @click="createCalendar = true">Create New Calendar</button></li>
                                        <li><button type="button" @click="logout">Logout</button></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <i-gg-more-vertical-o style="color: var(--base-100); font-size: 2em" />
                        <li><i-gg-chevron-left-o style="font-size: 2rem" @click="lastWeek" /></li>
                        <li><i-gg-chevron-right-o style="font-size: 2rem" @click="nextWeek" /></li>
                    </ul>
                </nav>
            </header>
            <main class="mx-10">
                <CreateCalendarModal :createCalendar="createCalendar" @close="createCalendar = false" />
                <slot />
            </main>
        </div>
        <div class="drawer-side">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <SidebarCalendar />
        </div>
    </div>
</template>
<script setup lang="ts">
import CreateCalendarModal from '@/components/Planner/CreateCalendarModal.vue';
import SidebarCalendar from '@/components/SidebarCalendar/index.vue';
import { useDateState } from '@/composables/useDateState';
import { getInitials } from '@/composables/useInitials';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { computed, ref, watch } from 'vue';
const { selectedYear, selectedMonth, selectedDate, setSelectedDate } = useDateState();

const $page = usePage() as any;
const displayedCalendar = computed(() => $page.props.calendar);
let calendarName = ref($page.props.calendar.name);
let selectedCalendarId = ref($page.props.calendar.id);
// Watch for calendar changes and update the name and selected ID
watch(() => $page.props.calendar, (newCalendar) => {
    calendarName.value = newCalendar.name;
    selectedCalendarId.value = newCalendar.id;
});
let initials = getInitials($page.props.auth.user.name);
const updateCalendar = () => {
    const selectedCalendar = $page.props.auth.user.calendars.find(calendar => calendar.id === selectedCalendarId.value);
    if (selectedCalendar) {
    router.get(route('calendars.show', { user_id: $page.props.auth.user.id, calendar: selectedCalendar.id }));
    // If you need to reload calendar data after navigation, you can call:
    router.reload();
    }
};



let isEditable = ref(false);
const calendarInput = ref(null);

const handleClick = () => {
    if (!isEditable.value) {
        isEditable.value = true;
        setTimeout(() => calendarInput.value?.focus(), 0);
    }
};

const handleBlur = () => {
    if (isEditable.value) {
        isEditable.value = false;
        if(calendarName.value.trim() !== displayedCalendar.value.name.trim()) {
            console.log('Updating calendar:', $page.props.calendar.id, 'with name:', calendarName.value);
            router.put(
                route('calendars.update', [$page.props.auth.user.id, $page.props.calendar.id]),
                { name: calendarName.value },
            );
        }
    }
};

let createCalendar = ref(false);

const lastWeek = () => {
    const currentDate = new Date(selectedYear.value, selectedMonth.value, selectedDate.value);
    const lastWeekDate = dayjs(currentDate).subtract(7, 'day');
    setSelectedDate(lastWeekDate.year(), lastWeekDate.month(), lastWeekDate.date());
};

const nextWeek = () => {
    const currentDate = new Date(selectedYear.value, selectedMonth.value, selectedDate.value);
    const nextWeekDate = dayjs(currentDate).add(7, 'day');
    setSelectedDate(nextWeekDate.year(), nextWeekDate.month(), nextWeekDate.date());
};

// Remove unused auth object, since user data comes from $page.props.auth.user
const logout = () => {
    router.post(route('logout'), {
        onSuccess: () => {
            router.get(route('login'));
        },
    });
};

const month = computed(() => {
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    console.log('Debug - selectedMonth.value:', selectedMonth.value, 'showing:', months[selectedMonth.value]);
    return `${months[selectedMonth.value]} ${selectedYear.value}`;
});
</script>
<style scoped>

#settings_anchor {
    anchor-name: --settings_anchor;
}
#settings {
    position-anchor: --settings_anchor;
    inset-block-start: anchor(--settings_anchor bottm);
    inset-inline-start: anchor(--settings_anchor left);
}
[popover] {
    opacity: 0;
    background: var(--color-base-100);
    color: var(--color-slate-800);
    transform: scale(0.8);
    transition:
        opacity 300ms,
        transform 300ms;
    &:popover-open {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
