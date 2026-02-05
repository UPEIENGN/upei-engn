<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { PromoCode } from '@/types';
import { PlusCircle, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    modelValue: PromoCode[];
    error?: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

const newCode = ref<string>('');
const newValue = ref<number>();
const newType = ref<'amount' | 'percentage'>('amount'); // Changed from newIsPercentage
const valueError = ref<string | undefined>(undefined);

const addPromoCode = () => {
    valueError.value = undefined; // Reset error

    if (!newCode.value) {
        // Optionally handle code validation
        return;
    }

    if (newValue.value === undefined || newValue.value < 0) {
        valueError.value = 'Value must be a positive number.';
        return;
    }

    if (newType.value === 'percentage' && (newValue.value > 100 || newValue.value < 0)) {
        valueError.value = 'Percentage must be between 0 and 100.';
        return;
    }

    if (newCode.value) {
        const updatedPromoCodes = [
            ...props.modelValue,
            {
                code: newCode.value,
                type: newType.value,
                value: newValue.value,
            },
        ];
        emit('update:modelValue', updatedPromoCodes);
        newCode.value = '';
        newValue.value = undefined;
        newType.value = 'amount'; // Reset to default
    }
};

const removePromoCode = (index: number) => {
    const updatedPromoCodes = props.modelValue.filter((_, i) => i !== index);
    emit('update:modelValue', updatedPromoCodes);
};
</script>

<template>
    <div class="grid gap-2">
        <Label>Promo Codes</Label>
        <div class="space-y-4">
            <div
                v-for="(promo, index) in modelValue"
                :key="index"
                class="flex items-center space-x-2 rounded-md border p-2"
            >
                <div class="flex-1">
                    <p class="font-medium">{{ promo.code }}</p>
                    <p class="text-sm text-gray-500">
                        {{ promo.type == 'percentage' ? promo.value + '%' : '$' + Number(promo.value).toFixed(2) }} off
                    </p>
                </div>
                <Button variant="ghost" size="icon" @click="removePromoCode(index)">
                    <Trash2 class="h-4 w-4 text-red-500" />
                </Button>
            </div>
            <div class="flex items-end gap-4">
                <div class="grid flex-1 gap-2">
                    <Label>New  Code</Label>
                    <Input v-model="newCode" placeholder="Promo Code" @keyup.enter="addPromoCode" />
                </div>
                <div class="grid gap-2">
                    <Label>Value</Label>
                    <Input
                        v-model.number="newValue"
                        type="number"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        @keyup.enter="addPromoCode"
                    />
                </div>
                <div class="grid gap-2">
                    <Label>Type</Label>
                    <RadioGroup v-model="newType" default-value="amount" class="flex gap-4 h-9">
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="type-amount" value="amount" />
                            <Label for="type-amount">Amount</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="type-percentage" value="percentage" />
                            <Label for="type-percentage">Percentage</Label>
                        </div>
                    </RadioGroup>
                </div>
                <Button type="button" size="icon" @click="addPromoCode">
                    <PlusCircle class="h-4 w-4" />
                </Button>
            </div>
            <InputError :message="valueError" />
        </div>
        <InputError :message="error" />
    </div>
</template>


