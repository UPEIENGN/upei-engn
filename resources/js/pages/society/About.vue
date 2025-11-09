<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Society } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    society: Society;
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society"> </SocietyLayout>
</template>

<style scoped></style>
