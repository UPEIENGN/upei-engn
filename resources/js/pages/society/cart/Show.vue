<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Head, InertiaForm, router, useForm } from '@inertiajs/vue3';
import { ChevronDown, X } from 'lucide-vue-next';
import { Cart, CartItem, Society } from '@/types';
import { computed, onBeforeMount, onMounted, ref } from 'vue';

interface Props {
    society: Society;
    cart: Cart;
}

const props = defineProps<Props>();

interface QuantityForm {
    quantity: number;
}

const quantityForms = ref<Record<number, InertiaForm<QuantityForm>>>({});

onBeforeMount(() => {
    props.cart.items.forEach((item) => {
        quantityForms.value[item.id] = useForm<QuantityForm>({
            quantity: item.quantity,
        });
    });
});

const updateQuantity = (item: CartItem) => {
    quantityForms.value[item.id].put(route('cart-items.update', { cart_item: item.id }), {
        preserveScroll: true,
        preserveState: true,
    });
};

const removeItem = (item: CartItem) => {
    router.delete(route('cart-items.destroy', { cart_item: item.id }), {
        preserveScroll: true,
        preserveState: true,
    });
};

const subtotal = computed(() => {
    return props.cart.items.reduce((sum, item) => {
        return sum + item.product.price * item.quantity;
    }, 0);
});

// This should ideally come from config or backend
const taxRate = 0.15;
const taxEstimate = computed(() => subtotal.value * taxRate);
const orderTotal = computed(() => subtotal.value + taxEstimate.value);

function generateQuantityOptions(stock: number): number[] {
    const options = [];
    for (let i = 1; i <= stock; i++) {
        options.push(i);
    }
    return options;
}
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="bg-white">
            <main class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

                <form v-if="cart.items.length > 0" class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-t border-b border-gray-200">
                            <li v-for="cartItem in cart.items" :key="cartItem.id" class="flex py-6 sm:py-10">
                                <div class="shrink-0">
                                    <img
                                        :src="cartItem.product.images?.[0]?.url ?? 'https://placehold.co/100'"
                                        :alt="cartItem.product.name"
                                        class="size-24 rounded-md object-cover sm:size-48"
                                    />
                                </div>

                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <h3 class="text-sm">
                                                    <a
                                                        :href="route('products.show', { product: cartItem.product.id })"
                                                        class="font-medium text-gray-700 hover:text-gray-800"
                                                        >{{ cartItem.product.name }}</a
                                                    >
                                                </h3>
                                            </div>
                                            <div class="mt-1 flex text-sm">
                                                <p v-if="cartItem.color" class="text-gray-500 uppercase">{{ cartItem.color }}</p>
                                                <p
                                                    v-if="cartItem.size"
                                                    :class="cartItem.color ? 'ml-4 border-l border-gray-200 pl-4' : ''"
                                                    class="text-gray-500 uppercase"
                                                >
                                                    {{ cartItem.size }}
                                                </p>
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-gray-900">${{ cartItem.product.price }}</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <div class="inline-grid w-full max-w-16 grid-cols-1">
                                                <select
                                                    :id="`quantity-${cartItem.id}`"
                                                    :name="`quantity-${cartItem.id}`"
                                                    :aria-label="`Quantity, ${cartItem.product.name}`"
                                                    v-model="quantityForms[cartItem.id].quantity"
                                                    @change="updateQuantity(cartItem)"
                                                    :disabled="quantityForms[cartItem.id].processing"
                                                    class="col-start-1 row-start-1 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6"
                                                >
                                                    <option
                                                        v-for="option in generateQuantityOptions(cartItem.product.stock)"
                                                        :key="option"
                                                        :value="option"
                                                    >
                                                        {{ option }}
                                                    </option>
                                                </select>
                                                <ChevronDown
                                                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                    aria-hidden="true"
                                                />
                                            </div>

                                            <div class="absolute top-0 right-0">
                                                <button
                                                    type="button"
                                                    @click="removeItem(cartItem)"
                                                    class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500"
                                                >
                                                    <span class="sr-only">Remove</span>
                                                    <X class="size-5" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">${{ subtotal.toFixed(2) }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex text-sm text-gray-600">
                                    <span>Tax estimate ({{ taxRate * 100 }}%)</span>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">${{ taxEstimate.toFixed(2) }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">${{ orderTotal.toFixed(2) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <button
                                type="submit"
                                class="w-full cursor-pointer rounded-md border border-transparent bg-gray-600 px-4 py-3 text-base font-medium text-white shadow-xs hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden"
                            >
                                Checkout
                            </button>
                        </div>
                    </section>
                </form>

                <div v-else class="mt-12 text-center text-gray-500 text-lg">
                    There are no items in your cart right now.
                </div>

            </main>
        </div>
    </SocietyLayout>
</template>

<style scoped></style>
