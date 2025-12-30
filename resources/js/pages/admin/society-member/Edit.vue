<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Society, SocietyMember } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import ImageInput from '@/pages/admin/product/ImageInput.vue';

interface Props {
    society: Society;
    member: SocietyMember;
    roles: { name: string; value: number }[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: route('admin.societies.events.index', { society: props.society }),
    },
    {
        title: 'Edit Society Member',
        href: route('admin.societies.society-members.edit', { society: props.society, society_member: props.member }),
    },
];

const form = useForm({
    _method: 'PATCH',
    name: props.member.name,
    email: props.member.email,
    role: props.member.role,
    title: props.member.title,
    description: props.member.description,
    image: undefined
});

const submit = () => {
    form.post(route('admin.societies.society-members.update', { society: props.society, society_member: props.member }), {forceFormData: true});
};
</script>

<template>
    <Head title="Edit Society Member" />

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

                        <div class="grid gap-2">
                            <ImageInput :error="form.errors.image" @image-selected="(image) => form.image = image">
                                <template #current-image>
                                    <img :src="member.image?.url" alt="Preview Image"
                                         class="aspect-square rounded-lg bg-gray-200 object-cover xl:aspect-7/8" />
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
