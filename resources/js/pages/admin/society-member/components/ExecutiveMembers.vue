<script setup lang="ts">
import { SocietyMember } from '@/types';
import { Plus } from 'lucide-vue-next';

interface Props {
    executives: SocietyMember[];
}

defineProps<Props>();
</script>

<template>
    <div class="bg-background">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <ul
                role="list"
                class="mx-auto mt-6 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-16 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6"
            >
                <li v-for="member in executives" :key="member.email">
                    <!--                                            <img-->
                    <!--                                                class="mx-auto size-24 rounded-full outline-1 -outline-offset-1 outline-black/5 dark:outline-white/10"-->
                    <!--                                                :src="member.imageUrl"-->
                    <!--                                                alt=""-->
                    <!--                                            />-->
                    <h3 class="mt-6 text-base/7 font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ member.name }}
                    </h3>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        {{ member.role }}
                    </p>
                </li>
                <li>
                    <div
                        class="mx-auto flex size-24 cursor-pointer items-center justify-center rounded-full bg-gray-200 outline-1 -outline-offset-1 outline-black/5 hover:bg-gray-300 dark:bg-neutral-900 dark:outline-white/10 dark:hover:bg-neutral-800"
                    >
                        <Plus class="size-12" />
                    </div>
                    <h3 class="mt-6 text-base/7 font-semibold tracking-tight text-gray-900 dark:text-white">Add Executive</h3>
                </li>
            </ul>
        </div>
    </div>
</template>
