<script setup lang="ts">
import SocietyLayout from '@/layouts/society/SocietyLayout.vue';
import { Product, Society } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    society: Society;
    product: Product;
}

defineProps<Props>();
</script>

<template>
    <Head :title="society.name" />

    <SocietyLayout :society="society">
        {{product}}
    </SocietyLayout>
</template>

<style scoped></style>
