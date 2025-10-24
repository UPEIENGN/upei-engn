<script setup lang="ts">
import { CalendarEntry } from '@/types';
import { Clock } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Props {
    calendar: CalendarEntry[];
}

const props = defineProps<Props>();

const selected = ref<CalendarEntry>(<CalendarEntry>props.calendar.find((day) => day.isToday));

const monthYear = computed(() =>
    new Intl.DateTimeFormat('en-US', {
        month: 'long',
        year: 'numeric',
    }).format(new Date()),
);

const formatTime = (datetime: string) => {
    const date = new Date(datetime)
    return date.toLocaleString('en-US', {
        hour: 'numeric',
        hour12: true,
    })
}

function selectDate(day: CalendarEntry) {
    selected.value = day;
}
</script>

<template>
    <div class="lg:flex lg:h-full lg:flex-col">
        <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none dark:border-neutral-900 bg-background">
            <h1 class="text-base font-semibold text-gray-900 dark:text-white">
                {{ monthYear }}
            </h1>
        </header>
        <div class="shadow-sm ring-1 ring-black/5 lg:flex lg:flex-auto lg:flex-col dark:shadow-none dark:ring-white/5">
            <div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-background text-center text-xs/6 font-semibold text-gray-700 lg:flex-none dark:border-white/5 dark:text-gray-300">
                <div class="flex justify-center py-2 bg-background">
                    <span>S</span>
                    <span class="sr-only sm:not-sr-only">un</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>M</span>
                    <span class="sr-only sm:not-sr-only">on</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>T</span>
                    <span class="sr-only sm:not-sr-only">ue</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>W</span>
                    <span class="sr-only sm:not-sr-only">ed</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>T</span>
                    <span class="sr-only sm:not-sr-only">hu</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>F</span>
                    <span class="sr-only sm:not-sr-only">ri</span>
                </div>
                <div class="flex justify-center py-2 bg-background">
                    <span>S</span>
                    <span class="sr-only sm:not-sr-only">at</span>
                </div>
            </div>
            <div class="flex bg-gray-200 text-xs/6 text-gray-700 lg:flex-auto dark:bg-neutral-900 dark:text-gray-300">
                <div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-5 lg:gap-px">
                    <div
                        v-for="day in calendar"
                        :key="day.date"
                        :data-is-current-month="day.isCurrentMonth ? '' : undefined"
                        :data-is-today="day.isToday ? '' : undefined"
                        class="group relative bg-neutral-50 dark:bg-background px-3 py-2 text-gray-500 data-is-current-month:bg-white dark:text-gray-400 dark:not-data-is-current-month:before:pointer-events-none dark:not-data-is-current-month:before:absolute dark:not-data-is-current-month:before:inset-0 dark:not-data-is-current-month:before:bg-neutral-900 dark:data-is-current-month:bg-background"
                    >
                        <div class="relative group-not-data-is-current-month:opacity-75 in-data-is-today:flex in-data-is-today:size-6 in-data-is-today:items-center in-data-is-today:justify-center in-data-is-today:rounded-full in-data-is-today:bg-neutral-600 in-data-is-today:font-semibold in-data-is-today:text-white dark:in-data-is-today:bg-neutral-500">
                            {{ day.date.split('-').pop()!.replace(/^0/, '') }}
                        </div>
                        <ol v-if="day.events.length > 0" class="mt-2">
                            <li v-for="event in day.events.slice(0, 2)" :key="event.id">
                                <div class="group flex">
                                    <p class="flex-auto truncate font-medium text-gray-900 group-hover:text-neutral-600 dark:text-white dark:group-hover:text-neutral-400">
                                        {{ event.title }}
                                    </p>
                                    <time :datetime="event.start" class="ml-3 hidden flex-none text-gray-500 group-hover:text-neutral-600 xl:block dark:text-gray-400 dark:group-hover:text-neutral-400">
                                        {{ formatTime(event.start) }}
                                    </time>
                                </div>
                            </li>
                            <li v-if="day.events.length > 2" class="text-gray-500 dark:text-gray-400">+ {{ day.events.length - 2 }} more</li>
                        </ol>
                    </div>
                </div>
                <div class="isolate grid w-full grid-cols-7 grid-rows-6 gap-px lg:hidden">
                    <button
                        v-for="day in calendar"
                        :key="day.date"
                        type="button"
                        @click="selectDate(day)"
                        :data-is-current-month="day.isCurrentMonth ? '' : undefined"
                        :data-is-selected="day.date == selected?.date ? '' : undefined"
                        :data-is-today="day.isToday ? '' : undefined"
                        class="group relative flex h-14 flex-col px-3 py-2 not-data-is-current-month:bg-gray-50 not-data-is-selected:not-data-is-current-month:not-data-is-today:text-gray-500 hover:bg-gray-100 focus:z-10 data-is-current-month:bg-white not-data-is-selected:data-is-current-month:not-data-is-today:text-gray-900 data-is-current-month:hover:bg-gray-100 data-is-selected:font-semibold data-is-selected:text-white data-is-today:font-semibold not-data-is-selected:data-is-today:text-neutral-600 dark:not-data-is-current-month:bg-gray-900 dark:not-data-is-selected:not-data-is-current-month:not-data-is-today:text-gray-400 dark:not-data-is-current-month:before:pointer-events-none dark:not-data-is-current-month:before:absolute dark:not-data-is-current-month:before:inset-0 dark:not-data-is-current-month:before:bg-gray-800/50 dark:hover:bg-gray-900/50 dark:data-is-current-month:bg-gray-900 dark:not-data-is-selected:data-is-current-month:not-data-is-today:text-white dark:data-is-current-month:hover:bg-gray-900/50 dark:not-data-is-selected:data-is-today:text-neutral-400"
                    >
                        <span class="ml-auto group-not-data-is-current-month:opacity-75 in-data-is-selected:flex in-data-is-selected:size-6 in-data-is-selected:items-center in-data-is-selected:justify-center in-data-is-selected:rounded-full in-data-is-selected:not-in-data-is-today:bg-gray-900 in-data-is-selected:in-data-is-today:bg-neutral-600 dark:in-data-is-selected:not-in-data-is-today:bg-white dark:in-data-is-selected:not-in-data-is-today:text-gray-900 dark:in-data-is-selected:in-data-is-today:bg-neutral-500">
                            {{ day.date.split('-').pop()!.replace(/^0/, '') }}
                        </span>
                        <span class="sr-only">{day.events.length} events</span>
                        <span v-if="day.events.length > 0" class="-mx-0.5 mt-auto flex flex-wrap-reverse">
              <span v-for="event in day.events" :key="event.id" class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400 dark:bg-gray-500" />
            </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="relative px-4 py-10 sm:px-6 lg:hidden dark:after:pointer-events-none dark:after:absolute dark:after:inset-x-0 dark:after:top-0 dark:after:h-px dark:after:bg-white/10">
            <ol class="divide-y divide-gray-100 overflow-hidden rounded-lg text-sm shadow-sm outline-1 outline-black/5 dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                <li v-for="event in selected?.events" :key="event.id" class="group flex p-4 pr-6 focus-within:bg-gray-50 hover:bg-gray-50 dark:focus-within:bg-white/5 dark:hover:bg-white/5">
                    <div class="flex-auto">
                        <p class="font-semibold text-gray-900 dark:text-white">{{ event.title }}</p>
                        <time :datetime="event.start" class="mt-2 flex items-center text-gray-700 dark:text-gray-300">
                            <Clock class="mr-2 size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                            {{ formatTime(event.start) }}
                        </time>
                    </div>
                    <Link href="#" class="ml-6 flex-none self-center rounded-md px-3 py-2 font-semibold text-gray-900 opacity-0 shadow-xs ring-1 ring-gray-300 ring-inset group-hover:opacity-100 hover:ring-gray-400 focus:opacity-100 dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20 dark:hover:ring-white/5">
                        Edit<span class="sr-only">, {{ event.title }}</span>
                    </Link>
                </li>
            </ol>
        </div>
    </div>
</template>
