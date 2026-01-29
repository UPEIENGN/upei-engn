<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Product, Society } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    society: Society;
    products: Product[];
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="bg-white">
            <div class="mx-auto max-w-2xl p-6 lg:max-w-7xl">
                <h2 class="sr-only">Products</h2>

                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <Link v-for="product in products" :key="product.id" :href="route('products.show', {product: product})" class="group">
                        <img
                            :src="product.image?.url ?? 'https://placehold.co/200x300'"
                            alt=""
                            class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-7/8"
                        />
                        <h3 class="mt-4 text-lg text-gray-700">{{ product.name }}</h3>
                        <p class="text-md mt-1 font-medium text-gray-900">{{ product.price }}</p>
                        <p class="mt-1 text-sm font-light text-gray-500">{{ product.stock }} in stock</p>
                    </Link>
                </div>
            </div>
        </div>
    </SocietyLayout>
</template>

<style scoped></style>
