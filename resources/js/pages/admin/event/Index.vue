<script setup lang="ts">
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { columns } from '@/pages/admin/event/components/columns';
import EventCalendar from '@/pages/admin/event/components/EventCalendar.vue';
import { BreadcrumbItem, CalendarEntry, Event, Pagination, Society } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { CalendarDays, CalendarPlus2 } from 'lucide-vue-next';

interface Props {
    society: Society;
    events: Pagination<Event>;
    upcoming: Event[];
    calendar: CalendarEntry[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: route('admin.societies.events.index', { society: props.society }),
    },
];

function onPaginationChange(pagination: { pageIndex: number; pageSize: number }) {
    router.get(
        route('admin.societies.events.index', {
            ...route().params,
            society: props.society.id,
            page: pagination.pageIndex + 1,
            per_page: pagination.pageSize,
        }),
        {},
        { preserveState: true, preserveScroll: true },
    );
}

function onFilterChange(filter: string) {
    router.get(
        route('admin.societies.events.index', {
            ...route().params,
            society: props.society.id,
            search: filter,
            page: 1,
        }),
        {},
        { preserveState: true, preserveScroll: true },
    );
}

function onSortChange(sort: { id: string; desc: boolean }[]) {
    router.get(
        route('admin.societies.events.index', {
            ...route().params,
            society: props.society.id,
            sort: sort[0]?.id,
            desc: sort[0]?.desc,
            page: 1,
        }),
        {},
        { preserveState: true, preserveScroll: true },
    );
}
</script>

<template>
    <Head title="Events" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 text-xl md:grid-cols-3">
                <div
                    class="relative flex aspect-video flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <div class="shrink-0 font-bold">Upcoming Events</div>

                    <div class="flex-1 space-y-1 overflow-y-auto text-base">
                        <div v-for="event in upcoming" :key="event.id">
                            <div class="truncate font-semibold">
                                {{ event.title }}
                            </div>
                            <div class="font-light">
                                {{ new Date(event.start).toLocaleString('en-CA') }}
                            </div>
                            <div class="truncate font-light">
                                {{ event.location }}
                            </div>
                        </div>
                    </div>
                </div>
                <Link
                    as="div"
                    :href="route('admin.societies.events.create', { society: society })"
                    class="relative flex aspect-video cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 p-4 font-bold hover:bg-gray-100 dark:border-sidebar-border dark:hover:bg-neutral-900"
                >
                    <CalendarPlus2 class="mr-2 size-5" />
                    Create New Event
                </Link>

                <Dialog>
                    <DialogTrigger as-child>
                        <div
                            class="relative flex aspect-video cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 p-4 font-bold hover:bg-gray-100 dark:border-sidebar-border dark:hover:bg-neutral-900"
                        >
                            <CalendarDays class="mr-2 size-5" />
                            View Calendar
                        </div>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[1225px]">
                        <DialogHeader>
                            <DialogTitle>Event Calendar</DialogTitle>
                        </DialogHeader>
                        <div>
                            <EventCalendar :calendar="calendar" />
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min">
                <DataTable
                    :society="society"
                    :columns="columns"
                    :pagination="events"
                    @pagination-changed="onPaginationChange"
                    search-key="title"
                    @filter-changed="onFilterChange"
                    @sort-changed="onSortChange"
                />
            </div>
        </div>
    </AppLayout>
</template>
