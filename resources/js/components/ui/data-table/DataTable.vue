<script setup lang="ts" generic="TData, TValue">
import type {
    ColumnDef,
    ColumnFiltersState,
    SortingState,
    VisibilityState,
} from '@tanstack/vue-table'

import {
    FlexRender,
    getCoreRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table'
import { valueUpdater } from '@/lib/utils'

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import DataTablePagination from '@/components/ui/data-table/DataTablePagination.vue';
import { ref } from 'vue';
import DataTableToolbar from '@/components/ui/data-table/DataTableToolbar.vue';
import { Pagination, Society } from '@/types';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[]
    pagination: Pagination<TData>
    society: Society,
}>()

const emit = defineEmits([
    'page-changed',
    'per-page-changed',
    'filter-changed'
])


const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const pagination = ref({
    pageIndex: props.pagination.current_page - 1, // TanStack uses 0-based index
    pageSize: props.pagination.per_page,
})

const table = useVueTable({
    get data() { return props.pagination.data },
    get columns() { return props.columns },
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get pagination() { return pagination.value },
    },
    enableRowSelection: true,
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => {
        valueUpdater(updaterOrValue, rowSelection)
    },
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    manualFiltering: true,
    onColumnFiltersChange: updaterOrValue => {
        valueUpdater(updaterOrValue, columnFilters)

        rowSelection.value = {}

        // send search query to server
        const filter = columnFilters.value[0]?.value ?? ''
        emit('filter-changed', filter)
    },
    manualPagination: true,
    onPaginationChange: (updaterOrValue) => {
        // update pageIndex locally (optional)
        valueUpdater(updaterOrValue, pagination)

        rowSelection.value = {}

        const newPage = pagination.value.pageIndex + 1

        emit('page-changed', newPage)
    },
    pageCount: props.pagination.last_page,
    rowCount: props.pagination.per_page,
})

function onPerPageChange(size: number) {
    rowSelection.value = {}

    emit('per-page-changed', size)
}
</script>

<template>
    <div class="space-y-4">
        <DataTableToolbar :table="table" />
        <div class="border rounded-md">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender
                                v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                :props="header.getContext()"
                            />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows" :key="row.id"
                            :data-state="row.getIsSelected() ? 'selected' : undefined"
                        >
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell :colspan="columns.length" class="h-24 text-center">
                                No results.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>

        <DataTablePagination :table="table" @per-page-changed="onPerPageChange"/>
    </div>
</template>
