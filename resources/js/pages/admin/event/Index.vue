<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { BreadcrumbItem, Pagination, Society, Event } from '@/types';
import {CalendarPlus2Icon} from 'lucide-vue-next';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

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
                    <CalendarPlus2Icon class="size-5 mr-2"/>
                    Create New Event
                </Link>
                <div class="p-4 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern/>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                Events Table
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
