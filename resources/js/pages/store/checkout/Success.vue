<script setup lang="ts">
import { Order } from '@/types';
import { Link } from '@inertiajs/vue3';

interface Props {
    order: Order;
}

defineProps<Props>();
</script>

<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg dark:bg-gray-800">
                <div
                    class="border-b border-gray-200 bg-white p-6 lg:p-8 dark:border-gray-700 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent"
                >
                    <h1 class="text-2xl font-medium text-gray-900 dark:text-white">Thank You for Your Order!</h1>

                    <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                        Your order #{{ order.id }} has been successfully placed and paid. A confirmation email has been sent to {{ order.email }}.
                    </p>

                    <div class="mt-4">
                        <Link
                            :href="route('store')"
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                        >
                            Continue Shopping
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
