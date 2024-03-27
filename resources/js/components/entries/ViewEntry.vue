<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import Word from './Word/Word.vue'

const entry = ref()
const entryComponent = computed(() => {
    if (entry.value?.type === 'WORD') {
        return 'WordEntry'
    }

    return 'NotSupportedYetEntry'
})
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
            alert('Error loading the entry...')
        })
}

</script>

<template>
    <Component
        v-if="entryComponent"
        :is="entryComponent"
        :entry="entry"
    />
    <div v-else>
        Loading...
    </div>
</template>
