<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { TagsInput, TagsInputInput, TagsInputItem, TagsInputItemDelete, TagsInputItemText } from '@/components/ui/tags-input';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import ImageInput from '@/pages/admin/product/ImageInput.vue';
import { type BreadcrumbItem, Product, Society } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

interface Props {
    society: Society;
    product: Product;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('admin.societies.products.index', { society: props.society }),
    },
    {
        title: 'Edit Product',
        href: route('admin.societies.products.edit', { society: props.society, product: props.product }),
    },
];

const form = useForm({
    _method: 'PUT',
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    colors: props.product.colors,
    sizes: props.product.sizes,
    image: undefined,
});

const submit = () => {
    form.post(route('admin.societies.products.update', { society: props.society, product: props.product }), { forceFormData: true });
};
</script>

<template>
    <Head title="Edit Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6 p-6">
                        <div class="grid gap-2">
                            <Label>Name</Label>
                            <Input required v-model="form.name" placeholder="Name" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Description</Label>
                            <Textarea v-model="form.description" placeholder="Description" />
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Price</Label>
                            <Input required v-model.number="form.price" placeholder="Price" type="number" step="0.01" min="0" inputmode="decimal" />
                            <InputError :message="form.errors.price" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Stock</Label>
                            <Input required v-model.number="form.stock" placeholder="Stock" type="number" min="0" />
                            <InputError :message="form.errors.stock" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Colors</Label>
                            <TagsInput v-model="form.colors">
                                <TagsInputItem v-for="item in form.colors" :key="item" :value="item">
                                    <TagsInputItemText />
                                    <TagsInputItemDelete />
                                </TagsInputItem>

                                <TagsInputInput placeholder="Colors..." />
                            </TagsInput>
                            <InputError :message="form.errors.colors" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Sizes</Label>
                            <TagsInput v-model="form.sizes">
                                <TagsInputItem v-for="item in form.sizes" :key="item" :value="item">
                                    <TagsInputItemText />
                                    <TagsInputItemDelete />
                                </TagsInputItem>

                                <TagsInputInput placeholder="Sizes..." />
                            </TagsInput>
                            <InputError :message="form.errors.sizes" />
                        </div>

                        <div class="grid gap-2">
                            <ImageInput :error="form.errors.image" @image-selected="(image) => (form.image = image)">
                                <template #current-image>
                                    <img
                                        :src="product.image.url"
                                        alt="Preview Image"
                                        class="aspect-square rounded-lg bg-gray-200 object-cover xl:aspect-7/8"
                                    />
                                </template>
                            </ImageInput>
                        </div>

                        <Button type="submit" class="mt-4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Save
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
