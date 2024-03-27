import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createWebHistory, createRouter } from 'vue-router';
import router from './routes'

import LayoutApp from './components/app/LayoutApp.vue';
import Sidebar from './components/app/Sidebar.vue';
import AddEntryModal from './components/entries/AddEntryModal.vue';
import Word from './components/entries/Word/Word.vue';
import NotSupportedYet from './components/entries/NotSupportedYet.vue';

const pinia = createPinia()
const app = createApp();

app.component('LayoutApp', LayoutApp)
app.component('Sidebar', Sidebar)
app.component('AddEntryModal', AddEntryModal)
app.component('WordEntry', Word)
app.component('NotSupportedYetEntry', NotSupportedYet)

app.use(pinia);
app.use(router);
app.mount('#app');
