<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { columns } from '@/pages/admin/order/components/columns';
import { type BreadcrumbItem, Order, Pagination, Society } from '@/types';
import { Head, router } from '@inertiajs/vue3';

interface Props {
    society: Society;
    orders: Pagination<Order>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: route('admin.societies.orders.index', { society: props.society }),
    },
];

function onPaginationChange(pagination: { pageIndex: number; pageSize: number }) {
    router.get(
        route('admin.societies.orders.index', {
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
        route('admin.societies.orders.index', {
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
        route('admin.societies.orders.index', {
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
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 text-xl md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min">
                <DataTable
                    :society="society"
                    :columns="columns"
                    :pagination="orders"
                    @pagination-changed="onPaginationChange"
                    search-key="name"
                    @filter-changed="onFilterChange"
                    @sort-changed="onSortChange"
                />
            </div>
        </div>
    </AppLayout>
</template>
