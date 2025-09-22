<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SocietyMember } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
    member: SocietyMember;
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
                <Link method="patch" :href="route('admin.societies.society-members.renew', { society: society, society_member: member })">
                    Renew Membership
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem>
                <Link :href="route('admin.societies.society-members.edit', { society: society, society_member: member })">
                    Edit Society Member
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem>
                <Link method="delete" :href="route('admin.societies.society-members.destroy', { society: society, society_member: member })">
                    Delete Society Member
                </Link>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
