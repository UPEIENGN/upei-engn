<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { CalendarDaysIcon, LayoutGrid, SettingsIcon, UsersIcon } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
        icon: LayoutGrid,
        isActive: route().current('admin.dashboard'),
        can: true
    },
    {
        title: 'Events',
        href: route('admin.societies.events.index', {society: page.props.society}),
        icon: CalendarDaysIcon,
        isActive: route().current('admin.societies.events.*'),
        can: true
    },
    {
        title: 'Society Members',
        href: route('admin.societies.society-members.index', {society: page.props.society}),
        icon: UsersIcon,
        isActive: route().current('admin.societies.society-members.*'),
        can: true
    },
    {
        title: 'Settings',
        href: route('admin.societies.edit', {society: page.props.society}),
        icon: SettingsIcon,
        isActive: route().current('admin.societies.edit'),
        can: true
    },
];

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('admin.dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
