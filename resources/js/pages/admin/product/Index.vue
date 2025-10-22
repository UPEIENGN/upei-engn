<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Pagination, Product, Society } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

interface Props {
    society: Society;
    products: Pagination<Product>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('admin.societies.products.index', { society: props.society }),
    },
];
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
<!--            <div class="grid auto-rows-min gap-4 md:grid-cols-3">-->
<!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
<!--                    <PlaceholderPattern />-->
<!--                </div>-->
<!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
<!--                    <PlaceholderPattern />-->
<!--                </div>-->
<!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
<!--                    <PlaceholderPattern />-->
<!--                </div>-->
<!--            </div>-->
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="flex flex-col items-center justify-center size-full rounded-xl bg-gray-800 text-white text-center px-4">
                    <h1 class="text-5xl font-bold mb-4">🚧 Coming Soon 🚧</h1>
                    <p class="text-lg text-gray-300">
                        Storefronts are still under active development. An update is coming soon to enable this feature.
                    </p>
                </div>
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
