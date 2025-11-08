<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { BreadcrumbItem, Pagination, Society, SocietyMember } from '@/types';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '@/pages/admin/society-member/components/columns';
import { UserPlus, UserStar } from 'lucide-vue-next';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import ExecutiveMembers from '@/pages/admin/society-member/components/ExecutiveMembers.vue';

interface Props {
    society: Society;
    members: Pagination<SocietyMember>;
    executives: SocietyMember[];
    allMembers: SocietyMember[];
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
    <Head title="Society Members" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 text-xl md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <Link
                    as="div"
                    :href="route('admin.societies.society-members.create', { society: society })"
                    class="relative flex aspect-video cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 p-4 font-bold hover:bg-gray-100 dark:border-sidebar-border dark:hover:bg-neutral-900"
                >
                    <UserPlus class="mr-2 size-5" />
                    Add Society Member
                </Link>
                <Dialog>
                    <DialogTrigger as-child>
                        <div
                            class="relative flex aspect-video cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 p-4 font-bold hover:bg-gray-100 dark:border-sidebar-border dark:hover:bg-neutral-900"
                        >
                            <UserStar class="mr-2 size-5" />
                            View Executives
                        </div>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[1225px]">
                        <DialogHeader>
                            <DialogTitle>Society Executives</DialogTitle>
                        </DialogHeader>
                        <div>
                            <ExecutiveMembers :society="society" :members="allMembers" :executives="executives" />
                        </div>
                    </DialogContent>
                </Dialog>
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
