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
            <div class="grid grid-cols-2 mt-5 gap-3">
                <div class="bg-[#F3EEEA] p-2 rounded">
                    <div>Samples</div>
                    <ul>
                        <li v-for="sample in samples">{{ sample }}</li>
                    </ul>

                    <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200">
                        <svg class="h-1.5 w-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                          <circle cx="3" cy="3" r="3" />
                        </svg>
                        Generated (AI)
                      </span>
                    <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200">
                    <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                      <circle cx="3" cy="3" r="3" />
                    </svg>
                    Oxford Dictionary
                  </span>

                    <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200">
                    <svg class="h-1.5 w-1.5 fill-blue-500" viewBox="0 0 6 6" aria-hidden="true">
                      <circle cx="3" cy="3" r="3" />
                    </svg>
                    Harvard Dictionary
                  </span>


                </div>
                <div class="bg-[#F3EEEA] p-2 rounded">Load Different Variations</div>
                <div class="bg-[#F3EEEA] p-2 rounded">Word Documentation</div>
                <div class="bg-[#F3EEEA] p-2 rounded">Practice Prononcuation</div>
                <div class="bg-[#F3EEEA] p-2 rounded">
                    <p>Practice</p>
                    <small>Translate to native language</small>
                    <small>Come up with few sentences (with help?)</small>
                    <small>chat: come up with questions to respond using that word</small>
                </div>
            </div>

        </div>
    </div>
</template>
