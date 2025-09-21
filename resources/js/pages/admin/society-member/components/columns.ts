import type { ColumnDef } from '@tanstack/vue-table';
import { SocietyMember } from '@/types';
import { h } from 'vue';
import { Checkbox } from '@/components/ui/checkbox';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import DataTableDropdown from '@/pages/admin/society-member/components/DataTableDropdown.vue';

export const columns: ColumnDef<SocietyMember>[] = [
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
        accessorKey: "name",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Name'
            })
        ),
    },
    {
        accessorKey: "email",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Email'
            })
        ),
    },
    {
        accessorKey: "role_label",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Role'
            })
        ),
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
        accessorKey: "renewed_at",
        header: ({ column }) => (
            h(DataTableColumnHeader, {
                column: column,
                title: 'Renewed At'
            })
        ),
        cell: ({ row }) => {
            const renewedAt: string = row.getValue('renewed_at')
            const isExpired = row.original.is_expired

            if (!renewedAt) {
                return h('div', { class: [isExpired ? 'text-red-500' : '','flex items-center'] }, "-")
            }

            const datetime = new Date(renewedAt)
            return h('div', { class: [isExpired ? 'text-red-500' : '','flex items-center'] }, datetime.toLocaleDateString('en-CA'))
        }
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const member = row.original

            return h(DataTableDropdown, { member })
        },
    },
]
