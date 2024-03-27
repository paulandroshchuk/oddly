<script setup>
import {ref, onMounted, watch, computed, defineProps} from 'vue'
import { useRoute } from 'vue-router'

const samples = ref([]);
const entry = computed(() => props.entry)
const props = defineProps({
    entry: Object,
})

onMounted(() => loadSamples())

function loadSamples() {
    axios.get(`/api/entries/${entry.value.id}/loadSamples`)
        .then(response => {
            samples.value = response.data.data
        })
        .catch(error => {
            alert('failed loading samples...')
        })
}

</script>

<template>
    <div class="p-2 border-l-green-400 border-l-2">
        <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-xl">#samples</h2>
        <div class="bg-gray-100 p-2 rounded">
            <ul>
                <li>- Hey do you think that is something good?</li>
                <li>- Yep, I <b class="underline">genuinely</b> believe that!</li>
            </ul>
        </div>
    </div>
</template>
