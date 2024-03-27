<script setup>
import {ref, onMounted, watch, computed} from 'vue'
import { useRoute } from 'vue-router'

const entry = ref()
const samples = ref([]);
const entryId = computed(() => useRoute().params.entry);

onMounted(() => {
    loadEntries()
})

function loadEntries() {
    axios.get(`/api/entries/${entryId.value}`)
        .then(response => {
            entry.value = response.data.data
        })
        .catch(error => {
            alert('fo')
        })

    axios.get(`/api/entries/${entryId.value}/samples`)
        .then(response => {
            samples.value = response.data.data
        })
        .catch(error => {
            alert('failed loading samples...')
        })
}

</script>

<template>
    <div>
        <div class="px-3">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ entry?.input }} <small class="text-sm">🍊</small></h2>

            <p class="text-gray-400 text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci aliquam aperiam aut doloremque, doloribus dolorum earum iure maxime nam nobis nulla, obcaecati odit quas sapiente totam ut vel voluptate?</p>
        </div>

        <hr class="h-px my-3 bg-gray-200 border-0 dark:bg-gray-700">

        <div class="px-3">
            Not supported yet...
        </div>
    </div>
</template>
