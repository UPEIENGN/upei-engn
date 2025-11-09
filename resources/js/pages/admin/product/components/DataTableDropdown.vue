<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Product } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    product: Product;
}

defineProps<Props>();

const page = usePage();

const society = computed(() => page.props.society);
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem>
                <Link :href="route('admin.societies.products.edit', { society: society, product: product })"> Edit Product </Link>
            </DropdownMenuItem>
            <DropdownMenuItem>
                <Link method="delete" :href="route('admin.societies.products.destroy', { society: society, product: product })">
                    Delete Product
                </Link>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
