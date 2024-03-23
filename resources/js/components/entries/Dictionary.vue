<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

const entries = ref()

onMounted(() => {
    loadEntries()
})

function loadEntries() {
    axios.get(`/api/entries`)
        .then(response => {
            entries.value = response.data.data
        })
        .catch(error => {
            alert('fo')
        })
}

</script>

<template>
    <div>
        <div class="px-3">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Dictionary</h2>

            <p class="text-gray-400 text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci aliquam aperiam aut doloremque, doloribus dolorum earum iure maxime nam nobis nulla, obcaecati odit quas sapiente totam ut vel voluptate?</p>
        </div>

        <hr class="h-px my-3 bg-gray-200 border-0 dark:bg-gray-700">

        <div class="px-3">
            <div class="grid gap-y-1">
                <div @click="$router.push({ path: `/entries/${entry.id}` })" v-for="entry in entries" :key="entry.id" class="p-1 px-2 rounded border-b-2 border-[#F3EEEA] tracking-tight border-dashed bg-[#F3EEEA] bg-opacity-50 cursor-pointer">
                    {{ entry.input }}
                </div>
            </div>
        </div>
    </div>
</template>
