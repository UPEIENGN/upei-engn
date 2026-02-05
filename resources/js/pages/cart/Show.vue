<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Cart, CartItem, Society } from '@/types';
import { Head, InertiaForm, Link, router, useForm } from '@inertiajs/vue3';
import { LoaderCircle, X } from 'lucide-vue-next';
import { computed, onBeforeMount, ref } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import InputError from '@/components/InputError.vue';
import { TagsInput, TagsInputInput, TagsInputItem, TagsInputItemDelete, TagsInputItemText } from '@/components/ui/tags-input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

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

const debouncedUpdateQuantity = useDebounceFn((item: CartItem) => updateQuantity(item), 500);

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

const form = useForm({
    promo_codes: [],
});

function checkout() {
    form.post(route('orders.store'));
}

// This should ideally come from config or backend
// const taxRate = 0.15;
// const taxEstimate = computed(() => subtotal.value * taxRate);
// const orderTotal = computed(() => subtotal.value + taxEstimate.value);
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <div class="bg-white">
            <main class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

                <form @submit.prevent="checkout" v-if="cart.items.length > 0" class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
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
                                                    <Link
                                                        :href="route('products.show', { product: cartItem.product.id })"
                                                        class="font-medium text-gray-700 hover:text-gray-800"
                                                        >{{ cartItem.product.name }}</Link
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
                                                <input
                                                    type="number"
                                                    :id="`quantity-${cartItem.id}`"
                                                    :name="`quantity-${cartItem.id}`"
                                                    :aria-label="`Quantity, ${cartItem.product.name}`"
                                                    v-model.number="quantityForms[cartItem.id].quantity"
                                                    @input="debouncedUpdateQuantity(cartItem)"
                                                    :disabled="quantityForms[cartItem.id].processing"
                                                    class="col-start-1 row-start-1 appearance-none rounded-md border border-gray-300 py-1.5 pr-3 pl-3 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                                                    min="1"
                                                />
                                            </div>

                                            <div class="absolute top-0 right-0">
                                                <button
                                                    type="button"
                                                    @click="removeItem(cartItem)"
                                                    class="-m-2 inline-flex cursor-pointer p-2 text-gray-400 hover:text-gray-500"
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
                            <!--                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">-->
                            <!--                                <dt class="flex text-sm text-gray-600">-->
                            <!--                                    <span>Tax estimate ({{ taxRate * 100 }}%)</span>-->
                            <!--                                </dt>-->
                            <!--                                <dd class="text-sm font-medium text-gray-900">${{ taxEstimate.toFixed(2) }}</dd>-->
                            <!--                            </div>-->
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">${{ subtotal.toFixed(2) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 grid gap-2">
                            <Label>Promo Codes</Label>
                            <TagsInput v-model="form.promo_codes">
                                <TagsInputItem v-for="item in form.promo_codes" :key="item" :value="item">
                                    <TagsInputItemText />
                                    <TagsInputItemDelete />
                                </TagsInputItem>

                                <TagsInputInput placeholder="Codes..." />
                            </TagsInput>
                            <InputError :message="form.errors.promo_codes" />
                        </div>

                        <div class="mt-6">
                            <Button type="submit"  :disabled="form.processing" class="w-full cursor-pointer rounded-md border border-transparent bg-gray-600 px-4 py-3 text-base font-medium text-white shadow-xs hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Checkout
                            </Button>
                        </div>
                    </section>
                </form>

                <div v-else class="mt-12 text-center text-lg text-gray-500">There are no items in your cart right now.</div>
            </main>
        </div>
    </SocietyLayout>
</template>

<style scoped></style>
