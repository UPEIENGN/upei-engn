<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { CalendarEntry, Society } from '@/types';
import { Head } from '@inertiajs/vue3';
import EventCalendar from '@/pages/admin/event/components/EventCalendar.vue';

interface Props {
    society: Society;
    calendar: CalendarEntry[];
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        <EventCalendar :calendar="calendar" />
    </SocietyLayout>
</template>
