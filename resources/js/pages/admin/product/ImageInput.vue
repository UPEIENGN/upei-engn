<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ref } from 'vue';

interface Props {
    error: string | undefined;
}

defineProps<Props>();

const emit = defineEmits(['images-selected']);

const imageUrls = ref<string[]>([]);

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = target.files;
    imageUrls.value = [];

    if (files) {
        const fileArray = Array.from(files);
        for (const file of fileArray) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if (e.target?.result) {
                        imageUrls.value.push(e.target.result as string);
                    }
                };
                reader.readAsDataURL(file);
            }
        }
        emit('images-selected', fileArray);
    }
};
</script>

<template>
    <Label>Images</Label>
    <Input type="file" @input="handleFileChange" multiple />
    <InputError :message="error" />
    <div class="flex w-full items-start gap-2">
        <div v-if="$slots['current-image']" class="grid w-1/2 gap-2">
            <Label>Current Images</Label>
            <slot name="current-image" />
        </div>
        <div v-if="imageUrls.length" class="grid w-1/2 gap-2">
            <Label>Uploaded Images</Label>
            <div class="grid grid-cols-2 gap-2">
                <img v-for="(url, index) in imageUrls" :key="index" :src="url" alt="Preview Image" class="aspect-square rounded-lg bg-gray-200 object-cover" />
            </div>
        </div>
    </div>
</template>
