import { Checkbox } from '@/components/ui/checkbox';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import DataTableDropdown from '@/pages/admin/product/components/DataTableDropdown.vue';
import { Product } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export const columns: ColumnDef<Product>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                modelValue: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
                'onUpdate:modelValue': (value) => table.toggleAllPageRowsSelected(!!value),
                ariaLabel: 'Select all',
                class: 'translate-y-0.5',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (value) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
                class: 'translate-y-0.5',
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'name',
        header: ({ column }) =>
            h(DataTableColumnHeader, {
                column: column,
                title: 'Name',
            }),
    },
    {
        accessorKey: 'price',
        header: ({ column }) =>
            h(DataTableColumnHeader, {
                column: column,
                title: 'Price',
            }),
    },
    {
        accessorKey: 'stock',
        header: ({ column }) =>
            h(DataTableColumnHeader, {
                column: column,
                title: 'Stock',
            }),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const product = row.original;

            return h(DataTableDropdown, { product });
        },
    },
];
