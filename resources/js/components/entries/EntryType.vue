<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const entryType = computed(() => route.params.entryType);
const entries = ref();

watch(entryType, () => {
    loadEntries();
});

function loadEntries() {
    axios.get(`/api/entries`, {
        params: {
            filter: {
                type: entryType.value,
            },
        },
    })
        .then(response => {
            entries.value = response.data.data;
        })
        .catch(error => {
            alert('fo')
        });
}

</script>

<template>
    <div>
        <h1 class="text-xl">{{ entryType }}</h1>

        <p class="text-gray-400 text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci aliquam aperiam aut doloremque, doloribus dolorum earum iure maxime nam nobis nulla, obcaecati odit quas sapiente totam ut vel voluptate?</p>

        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

        <div class="grid gap-y-1">
            <div @click="$router.push({ path: `/entries/${entry.id}` })" v-for="entry in entries" :key="entry.id" class="p-1 px-2 rounded border-b-2 border-yellow-400 border-dashed cursor-pointer">
                {{ entry.input }}
            </div>
        </div>
    </div>
</template>
