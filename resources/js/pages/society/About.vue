<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Society, SocietyMember } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    society: Society;
    executives: SocietyMember[]
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="bg-background py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-4xl font-semibold tracking-tight text-pretty text-neutral-900 sm:text-5xl dark:text-white">
                        Executive
                    </h2>
                    <p class="mt-6 text-lg/8 text-neutral-600 dark:text-neutral-400">
                        Meet the executive team responsible for guiding our society’s vision, operations, and member experience.
                    </p>
                </div>
                <ul role="list" class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4">
                    <li v-for="executive in executives" :key="executive.id">
                        <img class="aspect-14/13 w-full rounded-2xl object-cover outline-1 -outline-offset-1 outline-black/5 dark:outline-white/10"
                             src="https://placehold.co/200"
                             alt=""
                        />
                        <h3 class="mt-6 text-lg/8 font-semibold tracking-tight text-neutral-900 dark:text-white">
                            {{ executive.name }}
                        </h3>
                        <p class="text-base/7 text-neutral-600 dark:text-neutral-300">
                            {{ executive.title }}
                        </p>
                        <p class="text-sm/6 text-neutral-500">
                            {{ executive.description }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </SocietyLayout>
</template>
