<script setup lang="ts">
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { CalendarEntry } from '@/types';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    calendar: CalendarEntry[];
    canChangeMonths?: boolean;
}

const props = defineProps<Props>();

const emit = defineEmits(['change-month']);

const currentMonth = ref(props.calendar.find((d) => d.isCurrentMonth)?.date.slice(0, 7) || new Date().toISOString().slice(0, 7));

const selected = ref<CalendarEntry>(<CalendarEntry>props.calendar.find((day) => day.isToday));

const monthYear = computed(() =>
    new Intl.DateTimeFormat('en-US', {
        month: 'long',
        year: 'numeric',
    }).format(new Date(`${currentMonth.value}-01T12:00:00`)),
);

const formatTime = (datetime: string) => {
    const date = new Date(datetime);
    return date.toLocaleString('en-US', {
        hour: 'numeric',
        hour12: true,
    });
};

function selectDate(day: CalendarEntry) {
    selected.value = day;
}

function prevMonth() {
    const date = new Date(`${currentMonth.value}-01T12:00:00`);
    date.setMonth(date.getMonth() - 1);
    currentMonth.value = date.toISOString().slice(0, 7);
    emit('change-month', currentMonth.value);
}

function nextMonth() {
    const date = new Date(`${currentMonth.value}-01T12:00:00`);
    date.setMonth(date.getMonth() + 1);
    currentMonth.value = date.toISOString().slice(0, 7);
    emit('change-month', currentMonth.value);
}
</script>

<template>
    <div class="lg:flex lg:h-full lg:flex-col">
        <header class="flex items-center justify-between border-b border-neutral-200 bg-background px-6 py-4 lg:flex-none dark:border-neutral-900">
            <h1 class="text-base font-semibold text-neutral-900 dark:text-white">
                {{ monthYear }}
            </h1>
            <div v-if="canChangeMonths" class="flex items-center">
                <div
                    class="relative flex items-center rounded-md bg-white shadow-xs outline -outline-offset-1 outline-neutral-300 md:items-stretch dark:bg-white/10 dark:shadow-none dark:outline-white/5"
                >
                    <button
                        @click="prevMonth"
                        type="button"
                        class="flex h-9 w-12 cursor-pointer items-center justify-center rounded-l-md pr-1 text-neutral-400 hover:text-neutral-500 md:w-9 md:pr-0 md:hover:bg-neutral-50 dark:hover:text-white dark:md:hover:bg-white/10"
                    >
                        <span class="sr-only">Previous month</span>
                        <ChevronLeft class="size-5" aria-hidden="true" />
                    </button>

                    <button
                        @click="nextMonth"
                        type="button"
                        class="flex h-9 w-12 cursor-pointer items-center justify-center rounded-r-md pl-1 text-neutral-400 hover:text-neutral-500 md:w-9 md:pl-0 md:hover:bg-neutral-50 dark:hover:text-white dark:md:hover:bg-white/10"
                    >
                        <span class="sr-only">Next month</span>
                        <ChevronRight class="size-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </header>
        <div class="shadow-sm ring-1 ring-black/5 lg:flex lg:flex-auto lg:flex-col dark:shadow-none dark:ring-white/5">
            <div
                class="grid grid-cols-7 gap-px border-b border-neutral-300 bg-background text-center text-xs/6 font-semibold text-neutral-700 lg:flex-none dark:border-white/5 dark:text-neutral-300"
            >
                <div class="flex justify-center bg-background py-2">
                    <span>S</span>
                    <span class="sr-only sm:not-sr-only">un</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>M</span>
                    <span class="sr-only sm:not-sr-only">on</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>T</span>
                    <span class="sr-only sm:not-sr-only">ue</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>W</span>
                    <span class="sr-only sm:not-sr-only">ed</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>T</span>
                    <span class="sr-only sm:not-sr-only">hu</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>F</span>
                    <span class="sr-only sm:not-sr-only">ri</span>
                </div>
                <div class="flex justify-center bg-background py-2">
                    <span>S</span>
                    <span class="sr-only sm:not-sr-only">at</span>
                </div>
            </div>
            <div class="flex bg-neutral-200 text-xs/6 text-neutral-700 lg:flex-auto dark:bg-neutral-900 dark:text-neutral-300">
                <Dialog>
                    <div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px">
                        <DialogTrigger
                            as="div"
                            v-for="day in calendar"
                            :key="day.date"
                            :data-is-current-month="day.isCurrentMonth ? '' : undefined"
                            :data-is-today="day.isToday ? '' : undefined"
                            @click="selectDate(day)"
                            class="group relative cursor-pointer bg-neutral-50 px-3 py-2 text-neutral-500 data-is-current-month:bg-white dark:bg-background dark:text-neutral-400 dark:not-data-is-current-month:before:pointer-events-none dark:not-data-is-current-month:before:absolute dark:not-data-is-current-month:before:inset-0 dark:not-data-is-current-month:before:bg-neutral-900 dark:data-is-current-month:bg-background"
                        >
                            <div
                                class="relative group-not-data-is-current-month:opacity-75 in-data-is-today:flex in-data-is-today:size-6 in-data-is-today:items-center in-data-is-today:justify-center in-data-is-today:rounded-full in-data-is-today:bg-neutral-600 in-data-is-today:font-semibold in-data-is-today:text-white dark:in-data-is-today:bg-neutral-500"
                            >
                                {{ day.date.split('-').pop()!.replace(/^0/, '') }}
                            </div>
                            <ol v-if="day.events.length > 0" class="mt-2">
                                <li v-for="event in day.events.slice(0, 2)" :key="event.id">
                                    <div class="group flex">
                                        <p
                                            class="flex-auto truncate font-medium text-neutral-900 group-hover:text-neutral-600 dark:text-white dark:group-hover:text-neutral-400"
                                        >
                                            {{ event.title }}
                                        </p>
                                        <time
                                            :datetime="event.start"
                                            class="ml-3 hidden flex-none text-neutral-500 group-hover:text-neutral-600 xl:block dark:text-neutral-400 dark:group-hover:text-neutral-400"
                                        >
                                            {{ formatTime(event.start) }}
                                        </time>
                                    </div>
                                </li>
                                <li v-if="day.events.length > 2" class="text-neutral-500 dark:text-neutral-400">
                                    + {{ day.events.length - 2 }} more
                                </li>
                            </ol>
                        </DialogTrigger>
                    </div>

                    <div class="isolate grid w-full grid-cols-7 grid-rows-5 gap-px lg:hidden">
                        <DialogTrigger
                            as="button"
                            v-for="day in calendar"
                            :key="day.date"
                            type="button"
                            @click="selectDate(day)"
                            :data-is-current-month="day.isCurrentMonth ? '' : undefined"
                            :data-is-selected="day.date == selected?.date ? '' : undefined"
                            :data-is-today="day.isToday ? '' : undefined"
                            class="group relative flex h-14 flex-col bg-neutral-50 px-3 py-2 not-data-is-current-month:bg-neutral-50 not-data-is-selected:not-data-is-current-month:not-data-is-today:text-neutral-500 hover:bg-neutral-100 focus:z-10 data-is-current-month:bg-white not-data-is-selected:data-is-current-month:not-data-is-today:text-neutral-900 data-is-current-month:hover:bg-neutral-100 data-is-selected:font-semibold data-is-selected:text-white data-is-today:font-semibold not-data-is-selected:data-is-today:text-neutral-600 dark:bg-background dark:not-data-is-current-month:bg-neutral-900 dark:not-data-is-selected:not-data-is-current-month:not-data-is-today:text-neutral-400 dark:not-data-is-current-month:before:pointer-events-none dark:not-data-is-current-month:before:absolute dark:not-data-is-current-month:before:inset-0 dark:not-data-is-current-month:before:bg-neutral-800/50 dark:hover:bg-neutral-900/50 dark:data-is-current-month:bg-neutral-900 dark:not-data-is-selected:data-is-current-month:not-data-is-today:text-white dark:data-is-current-month:hover:bg-neutral-900/50 dark:not-data-is-selected:data-is-today:text-neutral-400"
                        >
                            <span
                                class="ml-auto group-not-data-is-current-month:opacity-75 in-data-is-selected:flex in-data-is-selected:size-6 in-data-is-selected:items-center in-data-is-selected:justify-center in-data-is-selected:rounded-full in-data-is-selected:not-in-data-is-today:bg-neutral-900 in-data-is-selected:in-data-is-today:bg-neutral-600 dark:in-data-is-selected:not-in-data-is-today:bg-white dark:in-data-is-selected:not-in-data-is-today:text-neutral-900 dark:in-data-is-selected:in-data-is-today:bg-neutral-500"
                            >
                                {{ day.date.split('-').pop()!.replace(/^0/, '') }}
                            </span>
                            <span class="sr-only">{day.events.length} events</span>
                            <span v-if="day.events.length > 0" class="-mx-0.5 mt-auto flex flex-wrap-reverse">
                                <span
                                    v-for="event in day.events"
                                    :key="event.id"
                                    class="mx-0.5 mb-1 size-1.5 rounded-full bg-neutral-400 dark:bg-neutral-500"
                                />
                            </span>
                        </DialogTrigger>
                    </div>

                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>{{ selected.date }}</DialogTitle>
                            <DialogDescription> There is {{ selected.events.length }} event(s) occurring. </DialogDescription>
                        </DialogHeader>
                        <div class="bg-background py-2 sm:py-4">
                            <div class="mx-auto max-w-7xl px-2 lg:px-4">
                                <div class="mx-auto max-w-2xl">
                                    <div class="space-y-4 divide-y">
                                        <article
                                            v-for="(event, index) in selected.events"
                                            :key="event.id"
                                            class="flex max-w-xl flex-col items-start justify-between"
                                            :class="{ 'pb-4': index !== selected.events.length - 1 }"
                                        >
                                            <div class="group relative space-y-2">
                                                <h3 class="text-lg/6 font-bold text-neutral-900 dark:text-white">
                                                    {{ event.title }}
                                                </h3>
                                                <p class="text-sm/6 font-semibold text-neutral-800 dark:text-neutral-300">
                                                    Start: {{ new Date(event.start).toLocaleString('en-CA') }}
                                                </p>
                                                <p class="text-sm/6 font-semibold text-neutral-800 dark:text-neutral-300">
                                                    End: {{ new Date(event.end).toLocaleString('en-CA') }}
                                                </p>
                                                <p class="line-clamp-3 text-sm/6 text-neutral-600 dark:text-neutral-400">
                                                    {{ event.description }}
                                                </p>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    </div>
</template>
