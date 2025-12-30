<script setup lang="ts">
import { ref } from 'vue';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';

interface Props {
    error: string | undefined;
}

defineProps<Props>()

const emit = defineEmits([
    'image-selected'
])


const imageUrl = ref('');

const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        // Use FileReader to generate a data URL
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(file); // Read the file as a data URL

        emit('image-selected', file);
    } else {
        // Reset if the file is not an image or no file selected
        imageUrl.value = '';
    }
};
</script>

<template>
    <Label>Image</Label>
    <Input type="file" @input="handleFileChange" />
    <InputError :message="error" />
    <div class="w-full flex gap-2 items-start">
        <div v-if="$slots['current-image']" class="w-1/2 grid gap-2">
            <Label>Current Image</Label>
            <slot name="current-image"/>
        </div>
        <div v-if="imageUrl" class="w-1/2 grid gap-2">
            <Label>Uploaded Image</Label>
            <img :src="imageUrl" alt="Preview Image"
                 class="aspect-square rounded-lg bg-gray-200 object-cover xl:aspect-7/8" />
        </div>
    </div>

</template>
