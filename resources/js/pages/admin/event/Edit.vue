<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn, toLocalISOString } from '@/lib/utils';
import { type BreadcrumbItem, Event, Society } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { DateFormatter, type DateValue, getLocalTimeZone, parseDate } from '@internationalized/date';
import { CalendarIcon, LoaderCircle } from 'lucide-vue-next';
import { ref, UnwrapRef } from 'vue';

interface Props {
    society: Society;
    event: Event;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: route('admin.societies.events.index', { society: props.society }),
    },
    {
        title: 'Edit Event',
        href: route('admin.societies.events.edit', { society: props.society, event: props.event }),
    },
];

const form = useForm({
    title: props.event.title,
    description: props.event.description,
    location: props.event.location,
    start: props.event.start,
    end: props.event.end,
});

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const toDateValue = (dateTimeStr: string): DateValue => {
    const jsDate = new Date(dateTimeStr);
    const dateStr = jsDate.toISOString().split('T')[0];
    return parseDate(dateStr);
};

const toTimeObject = (dateTimeStr: string): { hour: number; minutes: number; meridiem: string } => {
    const jsDate = new Date(dateTimeStr);
    let hours = jsDate.getHours();
    const minutes = jsDate.getMinutes();
    const meridiem = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    if (hours === 0) hours = 12;

    return { hour: hours, minutes, meridiem };
};

const startDate = ref<DateValue>(toDateValue(props.event.start));
const endDate = ref<DateValue>(toDateValue(props.event.end));

const startTime = ref<{ hour: number; minutes: number; meridiem: string }>(toTimeObject(props.event.start));
const endTime = ref<{ hour: number; minutes: number; meridiem: string }>(toTimeObject(props.event.end));

const toDateTimeString = (date: UnwrapRef<DateValue>, time: { hour: number; minutes: number; meridiem: string }) => {
    let hours = time.hour % 12;
    if (time.meridiem === 'PM') {
        hours += 12;
    }

    // Convert DateValue to JS Date
    const jsDate = date.toDate(getLocalTimeZone());
    jsDate.setHours(hours, time.minutes, 0, 0);

    return toLocalISOString(jsDate);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        start: toDateTimeString(startDate.value, startTime.value),
        end: toDateTimeString(endDate.value, endTime.value),
    })).put(route('admin.societies.events.update', { society: props.society, event: props.event }));
};
</script>

<template>
    <Head title="Edit Event" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6 p-6">
                        <div class="grid gap-2">
                            <Label>Title</Label>
                            <Input required v-model="form.title" placeholder="Title" />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Description</Label>
                            <Textarea v-model="form.description" placeholder="Description" />
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Location</Label>
                            <Input v-model="form.location" placeholder="Location" />
                            <InputError :message="form.errors.location" />
                        </div>

                        <div class="grid gap-2">
                            <Label>Start</Label>
                            <div class="flex items-center gap-x-2">
                                <Popover>
                                    <PopoverTrigger as-child>
                                        <Button
                                            variant="outline"
                                            :class="cn('w-3/4 justify-start text-left font-normal', !startDate && 'text-muted-foreground')"
                                        >
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ startDate ? df.format(startDate.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar v-model="startDate" initial-focus />
                                    </PopoverContent>
                                </Popover>

                                <Input v-model="startTime.hour" />
                                :
                                <Input v-model="startTime.minutes" />
                                <Select v-model="startTime.meridiem">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select a Meridiem" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="AM"> AM </SelectItem>
                                            <SelectItem value="PM"> PM </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>

                            <InputError :message="form.errors.start" />
                        </div>

                        <div class="grid gap-2">
                            <Label>End</Label>
                            <div class="flex items-center gap-x-2">
                                <Popover>
                                    <PopoverTrigger as-child>
                                        <Button
                                            variant="outline"
                                            :class="cn('w-3/4 justify-start text-left font-normal', !endDate && 'text-muted-foreground')"
                                        >
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ endDate ? df.format(endDate.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar v-model="endDate" initial-focus />
                                    </PopoverContent>
                                </Popover>

                                <Input v-model="endTime.hour" />
                                :
                                <Input v-model="endTime.minutes" />
                                <Select v-model="endTime.meridiem">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select a Meridiem" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem value="AM"> AM </SelectItem>
                                            <SelectItem value="PM"> PM </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>

                            <InputError :message="form.errors.end" />
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
