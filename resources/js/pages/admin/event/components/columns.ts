import { h } from 'vue'
import { Event } from "@/types";
import type { ColumnDef } from '@tanstack/vue-table'
import DataTableDropdown from '@/pages/admin/event/components/DataTableDropdown.vue'
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import {Checkbox} from '@/components/ui/checkbox'

export const columns: ColumnDef<Event>[] = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
            'class': 'translate-y-0.5',
        }),
        cell: ({ row }) => h(Checkbox, { 'modelValue': row.getIsSelected(), 'onUpdate:modelValue': value => row.toggleSelected(!!value), 'ariaLabel': 'Select row', 'class': 'translate-y-0.5' }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: "title",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Title'
            })
        ),
    },
    {
        accessorKey: "location",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Location'
            })
        ),
    },
    {
        accessorKey: "start",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Start'
            })
        ),
        cell: ({ row }) => {
            const datetime = new Date(row.getValue('start'))
            return h('div', { class: 'flex items-center' }, datetime.toLocaleString('en-CA'))
        }
    },
    {
        accessorKey: "end",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'End'
            })
        ),
        cell: ({ row }) => {
            const datetime = new Date(row.getValue('end'))
            return h('div', { class: 'flex items-center' }, datetime.toLocaleString('en-CA'))
        }
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const event = row.original

            return h(DataTableDropdown, { event })
        },
    },
]
