<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Product, Society } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Minus, Plus } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';

interface Props {
    society: Society;
    product: Product;
}

const props = defineProps<Props>();

const form = useForm({
    product_id: props.product.id,
    quantity: 1,
    color: props.product.colors?.[0] ?? null,
    size: props.product.sizes?.[0] ?? null,
});

const submit = () => {
    form.post(route('cart-items.store'), {
        preserveScroll: true,
    });
};

const incrementQuantity = () => {
    if (form.quantity < props.product.stock) {
        form.quantity++;
    }
};

const decrementQuantity = () => {
    if (form.quantity > 1) {
        form.quantity--;
    }
};
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="bg-white">
            <main class="mx-auto mt-8 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
                <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                    <div class="lg:col-span-5 lg:col-start-8">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-medium text-gray-900">{{ product.name }}</h1>
                            <p class="text-xl font-medium text-gray-900">$ {{ product.price }}</p>
                        </div>
                    </div>

                    <!-- Image gallery -->
                    <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                        <h2 class="sr-only">Images</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-3 lg:grid-rows-2 lg:gap-8">
                            <img
                                v-if="!product.images?.length"
                                alt="placeholder"
                                src="https://placehold.co/4000"
                                class="rounded-lg lg:col-span-3 lg:row-span-1"
                            />

                            <img
                                v-else
                                v-for="(image, index) in product.images"
                                :key="image.id"
                                :alt="image.original_name"
                                :src="image.url"
                                :class="[index === 0 ? 'w-full lg:col-span-3 lg:row-span-1' : 'hidden lg:block', 'rounded-lg']"
                            />
                        </div>
                    </div>

                    <div class="mt-8 lg:col-span-5">
                        <form @submit.prevent="submit">
                            <!-- Color picker -->
                            <div v-if="product.colors?.length">
                                <h2 class="text-sm font-medium text-gray-900">Color</h2>

                                <fieldset aria-label="Choose a color" class="mt-2">
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <label
                                            v-for="color in product.colors"
                                            :key="color"
                                            :aria-label="color"
                                            class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-600 has-checked:bg-gray-600 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-600 has-disabled:border-gray-400 has-disabled:bg-gray-200 has-disabled:opacity-25"
                                        >
                                            <input
                                                type="radio"
                                                :value="color"
                                                v-model="form.color"
                                                class="absolute inset-0 cursor-pointer appearance-none focus:outline-none disabled:cursor-not-allowed"
                                            />
                                            <span class="text-sm font-medium text-gray-900 group-has-checked:text-white">{{ color }}</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Size picker -->
                            <div class="mt-8" v-if="product.sizes?.length">
                                <h2 class="text-sm font-medium text-gray-900">Size</h2>

                                <fieldset aria-label="Choose a size" class="mt-2">
                                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                        <label
                                            v-for="size in product.sizes"
                                            :key="size"
                                            :aria-label="size"
                                            class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-600 has-checked:bg-gray-600 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-600 has-disabled:border-gray-400 has-disabled:bg-gray-200 has-disabled:opacity-25"
                                        >
                                            <input
                                                type="radio"
                                                :value="size"
                                                v-model="form.size"
                                                class="absolute inset-0 cursor-pointer appearance-none focus:outline-none disabled:cursor-not-allowed"
                                            />
                                            <span class="text-sm font-medium text-gray-900 group-has-checked:text-white">{{ size }}</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Quantity -->
                            <div class="mt-8">
                                <h2 class="text-sm font-medium text-gray-900">Quantity</h2>
                                <div class="mt-2 flex items-center">
                                    <button
                                        type="button"
                                        @click="decrementQuantity"
                                        class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                                        :disabled="form.quantity <= 1"
                                    >
                                        <Minus class="size-5" />
                                    </button>
                                    <span class="w-16 text-center text-gray-900">{{ form.quantity }}</span>
                                    <button
                                        type="button"
                                        @click="incrementQuantity"
                                        class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                                        :disabled="form.quantity >= product.stock"
                                    >
                                        <Plus class="size-5" />
                                    </button>
                                </div>
                                <InputError :message="form.errors.quantity" class="mt-2" />
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="mt-8 flex w-full cursor-pointer items-center justify-center rounded-md border border-transparent bg-gray-600 px-8 py-3 text-base font-medium text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-hidden disabled:opacity-50"
                            >
                                Add to cart
                            </button>
                        </form>

                        <!-- Product details -->
                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Description</h2>

                            <div class="mt-4 space-y-4 text-sm/6 text-gray-500">{{ product.description }}</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </SocietyLayout>
</template>

<style scoped></style>
