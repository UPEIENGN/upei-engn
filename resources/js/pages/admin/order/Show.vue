<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Order, Society } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

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
    <Head title="Order Details" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <form class="flex flex-col gap-6">
                    <div class="grid gap-6 p-6">
                        <div class="grid grid-cols-2 items-center gap-4">
                            <Label for="order-status">Payment Intent</Label>
                            <Input id="order-status" :model-value="props.order.payment_intent" readonly />
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <Label for="order-user">Name</Label>
                            <Input id="order-user" :model-value="props.order.name" readonly />
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <Label for="order-user-email">Email</Label>
                            <Input id="order-user-email" :model-value="props.order.email" readonly />
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <Label for="order-user-email">Phone</Label>
                            <Input id="order-user-email" :model-value="props.order.phone" readonly />
                        </div>

                        <div class="grid gap-2">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Product</TableHead>
                                        <TableHead class="text-right">Size</TableHead>
                                        <TableHead class="text-right">Color</TableHead>
                                        <TableHead class="text-right">Quantity</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="item in props.order.items" :key="item.id">
                                        <TableCell class="font-medium">{{ item.product.name }}</TableCell>
                                        <TableCell class="text-right">{{ item.size }}</TableCell>
                                        <TableCell class="text-right">{{ item.color }}</TableCell>
                                        <TableCell class="text-right">{{ item.quantity }}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
