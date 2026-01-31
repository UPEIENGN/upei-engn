<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { NavigationMenu, NavigationMenuItem, NavigationMenuLink, NavigationMenuList } from '@/components/ui/navigation-menu';
import SocietyFooter from '@/layouts/society/components/SocietyFooter.vue';
import { Can, type NavItem, Society } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { computed, ComputedRef } from 'vue';

interface Props {
    society: Society;
    can?: Can;
}

defineProps<Props>();

const navItems: ComputedRef<NavItem[]> = computed(() => [
    {
        title: 'Home',
        href: route('home'),
        isActive: route().current('home'),
        can: true,
    },
    {
        title: 'About',
        href: route('about'),
        isActive: route().current('about'),
        can: true,
    },
    {
        title: 'Events',
        href: route('events'),
        isActive: route().current('events'),
        can: true,
    },
    {
        title: 'Store',
        href: route('store'),
        isActive: route().current('store') || route().current('products.show'),
        can: true,
    },
]);
</script>

<template>
    <Head :title="society.name" />
    <div class="flex min-h-screen flex-col items-center p-6 lg:justify-center lg:p-8">
        <header class="w-full justify-end bg-white pb-6">
            <nav>
                <div class="flex items-center justify-end">
                    <div class="flex flex-1 items-center justify-end">
                        <div class="flow-root">
                            <Link :href="route('cart.show')" class="group relative flex items-center p-2">
                                <ShoppingCart class="size-6 shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                <div
                                    v-if="route().current('cart.show')"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                ></div>
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="relative h-[20vh] w-full overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
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

        <div class="flex w-full justify-center py-6">
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

        <div class="relative w-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <slot>
                <PlaceholderPattern />
            </slot>
        </div>
        <SocietyFooter :society="society" />
    </div>
</template>

<style scoped></style>
