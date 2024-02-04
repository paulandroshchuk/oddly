import './bootstrap';

import { createApp } from 'vue';
import WordMeaningInPhrase from './components/entries/WordMeaningInPhrase.vue';

const app = createApp();

app.component('WordMeaningInPhrase', WordMeaningInPhrase)

app.mount('#app');
