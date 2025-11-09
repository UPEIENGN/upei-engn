<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Society } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

interface Props {
    society: Society;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Settings',
        href: route('admin.societies.edit', { society: props.society }),
    },
];

const form = useForm({
    name: props.society.name,
    description: props.society.description,
    email: props.society.email,
    facebook_url: props.society.facebook_url,
    instagram_handle: props.society.instagram_handle,
    twitter_handle: props.society.twitter_handle,
    discord_url: props.society.discord_url,
    meeting_schedule: props.society.meeting_schedule,
    meeting_location: props.society.meeting_location,
});

function submit() {
    form.patch(route('admin.societies.update', { society: props.society }));
}
</script>

<template>
    <Head title="Society Settings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6 p-6">
                        <div class="grid gap-2">
                            <Label>Name</Label>
                            <Input required v-model="form.name" placeholder="Society Name" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Description</Label>
                            <Textarea v-model="form.description" placeholder="Description" />
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Main Contact Email</Label>
                            <Input type="email" required v-model="form.email" placeholder="email@example.com" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Facebook</Label>
                            <Input v-model="form.facebook_url" placeholder="https://www.facebook.com/sociecty" />
                            <InputError :message="form.errors.facebook_url" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Instagram</Label>
                            <Input v-model="form.instagram_handle" placeholder="https://www.instagram.com/society" />
                            <InputError :message="form.errors.instagram_handle" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Twitter</Label>
                            <Input v-model="form.twitter_handle" placeholder="https://x.com/society" />
                            <InputError :message="form.errors.twitter_handle" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Discord</Label>
                            <Input v-model="form.discord_url" placeholder="https://discord.gg/society" />
                            <InputError :message="form.errors.discord_url" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Meeting Schedule</Label>
                            <Input v-model="form.meeting_schedule" placeholder="" />
                            <InputError :message="form.errors.meeting_schedule" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Meeting Location</Label>
                            <Input v-model="form.meeting_location" placeholder="" />
                            <InputError :message="form.errors.meeting_location" />
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
