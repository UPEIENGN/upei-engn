<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { BreadcrumbItem, Pagination, Society, SocietyMember } from '@/types';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '@/pages/admin/society-member/components/columns';
import { UserPlus } from 'lucide-vue-next';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

interface Props {
    society: Society;
    members: Pagination<SocietyMember>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Society Members',
        href: route('admin.societies.society-members.index', { society: props.society }),
    },
];

function onPaginationChange(pagination: { pageIndex: number; pageSize: number }) {
    router.get(
        route('admin.societies.society-members.index', {
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
        route('admin.societies.society-members.index', {
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
    if (sort[0]?.id == 'role_label') {
        sort[0].id = 'role';
    }

    router.get(
        route('admin.societies.society-members.index', {
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
    <Head title="Members" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 text-xl">
                <Link as="div"
                      :href="route('admin.societies.society-members.create', {society: society})"
                      class="font-bold flex items-center justify-center cursor-pointer hover:bg-gray-100 p-4 relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <UserPlus class="size-5 mr-2"/>
                    Add Society Member
                </Link>
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
                    :pagination="members"
                    @pagination-changed="onPaginationChange"
                    search-key="name"
                    @filter-changed="onFilterChange"
                    @sort-changed="onSortChange"
                />
            </div>
        </div>
    </AppLayout>
</template>
