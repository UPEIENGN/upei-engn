<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Society } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import ImageInput from '@/pages/admin/product/ImageInput.vue';

interface Props {
    society: Society;
    roles: { name: string; value: number }[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: route('admin.societies.events.index', { society: props.society }),
    },
    {
        title: 'New Society Member',
        href: route('admin.societies.society-members.create', { society: props.society }),
    },
];

const form = useForm({
    name: undefined,
    email: undefined,
    role: undefined,
    title: undefined,
    description: undefined,
    paid_membership: false,
    image: undefined,
});

const submit = () => {
    form.post(route('admin.societies.society-members.store', { society: props.society }));
};
</script>

<template>
    <Head title="New Society Member" />

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
                            <Label>Email</Label>
                            <Input required type="email" v-model="form.email" placeholder="Email" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Role</Label>
                            <Select v-model="form.role">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select a role" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Roles</SelectLabel>
                                        <SelectItem v-for="role in roles" :value="role.value" :key="role.value">
                                            {{ role.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.role" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Title</Label>
                            <Input v-model="form.title" placeholder="Title" />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Description</Label>
                            <Textarea v-model="form.description" placeholder="Description" />
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="items-top flex gap-x-2">
                            <Checkbox id="paid-membership" v-model="form.paid_membership" />
                            <div class="grid gap-1.5 leading-none">
                                <label
                                    for="paid-membership"
                                    class="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    Paid Membership
                                </label>
                                <p class="text-sm text-muted-foreground">This member has paid there membership fee.</p>
                                <InputError :message="form.errors.paid_membership" />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <ImageInput :error="form.errors.image" @image-selected="(image) => form.image = image" />
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
