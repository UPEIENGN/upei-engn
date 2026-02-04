<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Order, Society } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    society: Society;
    order: Order;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: route('admin.societies.orders.index', { society: props.society }),
    },
    {
        title: `Order #${props.order.id}`,
        href: route('admin.societies.orders.show', { society: props.society, order: props.order }),
    },
];
</script>

<template>
    <Head title="Edit Event" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <form class="flex flex-col gap-6">
                    <div class="grid gap-6 p-6">
                        <div class="grid gap-2">
                            <Label>Title</Label>
                            <Input disabled placeholder="Title" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Description</Label>
                            <Input disabled placeholder="Location" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Location</Label>
                            <Input disabled placeholder="Location" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
