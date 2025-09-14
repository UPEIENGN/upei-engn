<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { BreadcrumbItem, Pagination, Society, Event } from '@/types';
import {CalendarPlus2} from 'lucide-vue-next';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '@/components/event/columns';

interface Props {
    society: Society;
    events: Pagination<Event>
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: route('admin.societies.events.index', { society: props.society }),
    },
];

function onPaginationChange(pagination: {pageIndex: number; pageSize: number}) {
    router.get(route('admin.societies.events.index', {
        ...route().params,
        society: props.society.id,
        page: pagination.pageIndex + 1,
        per_page: pagination.pageSize,
    }), {}, { preserveState: true, preserveScroll: true })
}

function onFilterChange(filter: string) {
    router.get(
        route('admin.societies.events.index', {
            ...route().params,
            society: props.society.id,
            search: filter,
            page: 1,
        }), {}, { preserveState: true, preserveScroll: true }
    )
}

function onSortChange(sort: {id: string, desc: boolean}[]) {
    router.get(
        route('admin.societies.events.index', {
            ...route().params,
            society: props.society.id,
            sort: sort[0]?.id,
            desc: sort[0]?.desc,
            page: 1,
        }), {}, { preserveState: true, preserveScroll: true }
    )
}
</script>

<template>
    <Head title="Events" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 text-xl">
                <div class="p-4 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    Upcoming Events
                </div>
                <Link as="div"
                      :href="route('admin.societies.events.create', {society: society})"
                      class="flex items-center justify-center cursor-pointer hover:bg-gray-100 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CalendarPlus2 class="size-5 mr-2"/>
                    Create New Event
                </Link>
                <div class="p-4 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern/>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min">
                <DataTable :society="society"
                           :columns="columns"
                           :pagination="events"
                           @pagination-changed="onPaginationChange"
                           @filter-changed="onFilterChange"
                           @sort-changed="onSortChange"/>
            </div>
        </div>
    </AppLayout>
</template>

