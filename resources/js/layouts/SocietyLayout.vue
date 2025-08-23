<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { NavigationMenu, NavigationMenuItem, NavigationMenuLink, NavigationMenuList } from '@/components/ui/navigation-menu';
import { Can, type NavItem, Society } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    society: Society;
    can?: Can;
}

defineProps<Props>();

const navItems: NavItem[] = [
    {
        title: 'Home',
        href: route('home'),
        isActive: route().current('home'),
        can: true,
    },
    {
        title: 'About',
        href: '',
        isActive: false,
        can: true,
    },
    {
        title: 'Events',
        href: '',
        isActive: false,
        can: true,
    },
    {
        title: 'Store',
        href: '',
        isActive: false,
        can: true,
    },
];
</script>

<template>
    <Head :title="society.name" />
    <div class="flex min-h-screen flex-col items-center p-6 lg:justify-center lg:p-8">
        <div class="w-full border-sidebar-border/70 dark:border-sidebar-border relative h-[20vh] overflow-hidden rounded-xl border">
            <img
                src="https://placehold.co/1300x200"
                :alt="society.name"
                class="absolute inset-0 h-full w-full rounded-xl object-cover"
                width="1300"
                height="200"
            />

            <div class="absolute inset-0 bg-black opacity-80"></div>

            <div class="relative flex h-full flex-col items-center justify-center p-4 text-center text-white">
                <h1 class="mb-4 text-4xl font-bold">{{ society.name }}</h1>
            </div>
        </div>

        <div class="w-full flex justify-center py-6">
            <NavigationMenu>
                <NavigationMenuList>
                    <template v-for="(item, index) in navItems">
                        <NavigationMenuItem v-if="item.can" :key="index" class="relative flex h-full items-center">
                            <Link :href="item.href">
                                <NavigationMenuLink>
                                    {{ item.title }}
                                </NavigationMenuLink>
                            </Link>
                            <div v-if="item.isActive" class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"></div>
                        </NavigationMenuItem>
                    </template>
                </NavigationMenuList>
            </NavigationMenu>
        </div>

        <div class="w-full border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
                <slot>
                    <PlaceholderPattern />
                </slot>
            </div>
    </div>

</template>

<style scoped></style>
