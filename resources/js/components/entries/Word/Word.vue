<script setup>
import {ref, onMounted, watch, computed, defineProps} from 'vue'
import { useRoute } from 'vue-router'
import WordSamples from './WordSamples.vue';

const entry = computed(() => props.entry)
const props = defineProps({
    entry: Object,
})
</script>

<template>
    <div>
        <div class="px-3">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ entry.input }}</h2>

            <p class="text-sm my-2 p-2 border-l-2 border-orange-300 bg-gray-50">
                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-xl">#definition</h2>
                <div class="mt-2">{{ entry.description }}</div>
            </p>

            <WordSamples :entry="entry" />
        </div>
    </div>
</template>
