<script setup>
import { ref, computed, onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useEntryTypesStore } from '@/stores/entryTypesStore';

const store = useEntryTypesStore();
const modals = ref({
    addEntry: false,
});

const { loading } = storeToRefs(store);

onMounted(() => {
    store.loadEntryTypes();
})
</script>

<template>
    <div class="border-r">
        <div>
            <h1>👀 Articles</h1>
            <h1>✍️ The Elements of Style</h1>
            <h1>🏈 Lifestyle</h1>
        </div>

        <div class="mt-5">
            <h1>💪 Practice</h1>
            <div>
                <ul>
                    <li class="text-xs">- Writing</li>
                    <li class="text-xs">- Words</li>
                    <li class="text-xs">- Pronunciation</li>
                    <li class="text-xs">- The Elements Of Style</li>
                    <li class="text-xs">- EoS -> Fix broken sentences into right with EoS rules</li>
                </ul>
            </div>
        </div>

        <div class="flex flex-row justify-between items-center mt-5">
            <h1>
                <RouterLink :to="{name: 'dictionary.index'}">📔 Dictionary</RouterLink>
            </h1>
            <span class="text-xs mr-5 cursor-pointer" @click="modals.addEntry = !modals.addEntry">
                <span class="bg-gray-100 p-0.5 rounded font-semibold text-xs"> Add </span>
            </span>
        </div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <ul>
                <li v-for="entryType in store.entryTypes" :key="entryType.id" class="text-xs">
                    <RouterLink
                        :to="{ name: 'entryType.show', params: { entryType: entryType.title } }"
                        class="hover:font-semibold">
                        - {{ entryType.title }} <span class="text-gray-600">{{ entryType.count }}</span>
                    </RouterLink>
                </li>
            </ul>
        </div>

        <AddEntryModal
            v-if="modals.addEntry"
            @close="modals.addEntry = false"
        />
    </div>
</template>
