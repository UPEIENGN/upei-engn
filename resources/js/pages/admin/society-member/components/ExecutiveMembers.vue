<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxItem, ComboboxList, ComboboxTrigger } from '@/components/ui/combobox';
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import type { Society, SocietyMember } from '@/types';
import { router } from '@inertiajs/vue3';
import { ChevronsUpDown, Plus, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    society: Society;
    executives: SocietyMember[];
    members: SocietyMember[];
}

const props = defineProps<Props>();

const executives = ref([...props.executives]);

const availableMembers = computed(() => props.members.filter((m) => !executives.value.some((e) => e.id === m.id)));

const draggingIndex = ref<number | null>(null);

function onDragStart(index: number) {
    draggingIndex.value = index;
}

function onDragOver(event: DragEvent, index: number) {
    event.preventDefault();

    const from = draggingIndex.value;
    const to = index;
    if (from === null || from === to) {
        return;
    }

    const arr = [...executives.value];
    const moved = arr.splice(from, 1)[0];
    arr.splice(to, 0, moved);

    draggingIndex.value = to;
    executives.value = arr;
}

function onDrop() {
    draggingIndex.value = null;
    saveOrder();
}

function removeExecutive(id: string) {
    executives.value = executives.value.filter((member) => member.id !== id);
    saveOrder();
}

const selectedMember = ref<SocietyMember | null>(null);

function addExecutive() {
    if (!selectedMember.value) {
        return;
    }

    const member = props.members.find((member) => member.id === selectedMember.value?.id);
    if (!member) {
        return;
    }

    executives.value.push(member);
    selectedMember.value = null;
    saveOrder();
}

function saveOrder() {
    const payload = executives.value.map((member, index) => ({
        id: member.id,
        order: index + 1,
    }));

    router.patch(
        route('admin.societies.executive-members.reorder', { society: props.society.id }),
        { executives: payload },
        {
            preserveScroll: true,
        },
    );
}
</script>

<template>
    <div class="bg-background">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <ul
                role="list"
                class="mx-auto mt-6 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-16 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6"
            >
                <li
                    v-for="(member, index) in executives"
                    :key="member.id"
                    draggable="true"
                    @dragstart="onDragStart(index)"
                    @dragover="onDragOver($event, index)"
                    @drop="onDrop"
                    class="relative cursor-move select-none"
                    :class="{ 'opacity-50': draggingIndex === index }"
                >
                    <img
                        class="mx-auto size-24 rounded-full outline-1 -outline-offset-1 outline-black/5 dark:outline-white/10"
                        src="https://placehold.co/200"
                        alt=""
                    />
                    <button class="absolute top-1 right-2 text-red-500 hover:text-red-700" @click.stop="removeExecutive(member.id)">
                        <X class="size-5" />
                    </button>

                    <h3 class="mt-6 text-base/7 font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ member.name }}
                    </h3>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        {{ member.title }}
                    </p>
                </li>

                <Dialog>
                    <DialogTrigger as-child>
                        <li>
                            <div
                                class="mx-auto flex size-24 cursor-pointer items-center justify-center rounded-full bg-gray-200 outline-1 -outline-offset-1 outline-black/5 hover:bg-gray-300 dark:bg-neutral-900 dark:outline-white/10 dark:hover:bg-neutral-800"
                            >
                                <Plus class="size-12" />
                            </div>
                            <h3 class="mt-6 text-base/7 font-semibold tracking-tight text-gray-900 dark:text-white">Add Executive</h3>
                        </li>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Add Executive</DialogTitle>
                        </DialogHeader>
                        <Combobox v-model="selectedMember" by="label">
                            <ComboboxAnchor as-child>
                                <ComboboxTrigger as-child>
                                    <Button variant="outline" class="justify-between">
                                        {{ selectedMember?.name ?? 'Select Society Member' }}

                                        <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                    </Button>
                                </ComboboxTrigger>
                            </ComboboxAnchor>

                            <ComboboxList class="max-h-60">
                                <ComboboxEmpty> No society member found. </ComboboxEmpty>

                                <ComboboxGroup>
                                    <ComboboxItem
                                        v-for="member in availableMembers"
                                        :key="member.id"
                                        :value="member"
                                        class="cursor-pointer hover:bg-accent hover:text-accent-foreground"
                                    >
                                        {{ member.name }}
                                    </ComboboxItem>
                                </ComboboxGroup>
                            </ComboboxList>
                        </Combobox>

                        <DialogFooter class="sm:justify-end">
                            <DialogClose as-child>
                                <Button @click="addExecutive" :disabled="!selectedMember" type="button"> Add Executive </Button>
                            </DialogClose>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </ul>
        </div>
    </div>
</template>
