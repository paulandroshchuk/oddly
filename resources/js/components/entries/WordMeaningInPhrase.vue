<script setup>
import { ref } from 'vue';

const word = ref('');
const context = ref('');

const loading = ref(false);

const response = ref(null);


function submit() {
    loading.value = true;

    axios
        // TODO: Use named routes package...
        // Same for ENUMs?
        .post('/api/entries', {
            input: word.value,
            type: 'WORD_MEANING_IN_PHRASE',
            context: context.value,
        })
        .then(r => {
            response.value = r.data.data;
        })
        .catch(e => {
            alert('error!');
        })
        .finally(() => {
            loading.value = false;
        })
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-x-5">
            <div class="shadow-xl p-5 rounded-xl">
                <p class="text-center">Guess Word Meaning By Phrase</p>
                <div class="grid grid-cols-1 gap-y-2">
                    <div>
                        <p>
                            <label for="word">Word</label>
                        </p>
                        <input type="text" v-model="word" class="w-full rounded">
                    </div>
                    <div>
                        <p>
                            <label for="context">Context</label>
                        </p>
                        <textarea v-model="context" class="w-full rounded" />
                    </div>
                    <div v-if="loading">
                        Looking up...
                    </div>
                    <div>
                        <button @submit="submit" class="px-4 w-full py-1.5 rounded bg-orange-300 border-2 border-orange-400 text-orange-100 font-mono hover:underline">Submit</button>
                    </div>
                    <div>
                        <p class="font-bold">- TODO: Error state</p>
                        <p class="font-bold">- TODO: Hide this form when response is ready</p>
                        <p class="font-bold">- TODO: When the word is used in different places</p>
                    </div>
                </div>
            </div>
            <div class="shadow-xl p-5 rounded-xl flex flex-col justify-between" v-if="response">
                <div>
                    <p>Word: {{ response.input }} <small class="underline">Try different word</small></p>
                    <p>Context: <b class="underline text-orange-400 border border-orange-500 rounded px-1 py-0.5 border-dashed">Hey</b> there, dude!</p>
                    <div>
                        The meaning of the word hey in the provided text is it describes the greeting of a person.
                        <ul>
                            <li>* View sample sentences</li>
                        </ul>
                    </div>
                    <div class="mt-5 p-2 border-2 border-dashed border-orange-400 rounded-md">
                        {{ response.meta.meaning }}
                    </div>
                </div>
                <div class="inset-x-0 bottom-0">
                    <div class="flex flex-row gap-x-2">
                        <a href="#" class="font-bold hover:underline">View Samples <small>(Pro Only)</small></a>
                        <a href="#" class="font-bold hover:underline">View Alternative Words / Synonymos</a>
                        <a href="#" class="font-bold hover:underline">Show part of the speech?</a>
                        <a href="#" class="font-bold hover:underline">Save</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
