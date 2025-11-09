<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Society } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    society: Society;
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="relative isolate overflow-hidden bg-background px-6 py-24 sm:py-32 lg:px-8">
            <img src="https://placehold.co/1300x600" alt="" class="absolute inset-0 -z-10 size-full object-cover opacity-10 dark:hidden" />
            <img src="https://placehold.co/1300x600" alt="" class="absolute inset-0 -z-10 size-full object-cover not-dark:hidden" />
            <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl" aria-hidden="true">
                <div class="aspect-1097/845 w-274.25 bg-linear-to-tr from-[#ff4694] to-[#776fff] opacity-15 dark:opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:-top-112 sm:ml-16 sm:translate-x-0" aria-hidden="true">
                <div class="aspect-1097/845 w-274.25 bg-linear-to-tr from-[#ff4694] to-[#776fff] opacity-15 dark:opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-5xl font-semibold tracking-tight text-neutral-900 sm:text-7xl dark:text-white">
                    {{ society.name }}
                </h2>
                <p class="mt-8 text-lg font-medium text-pretty text-neutral-700 sm:text-xl/8 dark:text-neutral-400">
                    {{ society.description }}
                </p>
            </div>
        </div>
    </SocietyLayout>
</template>
