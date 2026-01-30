<script setup lang="ts">

import { Cart } from '@/types';

interface Props {
    cart?: Cart
}

defineProps<Props>();
</script>

<template>
    {{cart}}
</template>

<style scoped></style>
