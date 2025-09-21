<script setup lang="ts" generic="TData">
import type { Table } from '@tanstack/vue-table'

import DataTableViewOptions from './DataTableViewOptions.vue'
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { computed } from 'vue';
import {X} from 'lucide-vue-next';

interface DataTableToolbarProps {
    table: Table<TData>;
    searchKey: string;
}

const props = defineProps<DataTableToolbarProps>()

const isFiltered = computed(() => props.table.getState().columnFilters.length > 0)
const isSorted = computed(() => props.table.getState().sorting.length > 0)

function reset() {
    props.table.resetColumnFilters()
    props.table.resetSorting()
}
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex flex-1 items-center space-x-2">
            <Input
                placeholder="Search..."
                :model-value="(table.getColumn(searchKey)?.getFilterValue() as string) ?? ''"
                class="h-8 w-[250px] lg:w-[350px]"
                @input="table.getColumn(searchKey)?.setFilterValue($event.target.value)"
            />

            <Button
                v-if="isFiltered || isSorted"
                variant="ghost"
                class="h-8 px-2 lg:px-3"
                @click="reset"
            >
                Reset
                <X class="ml-2 h-4 w-4" />
            </Button>
        </div>
        <DataTableViewOptions :table="table" />
    </div>
</template>
