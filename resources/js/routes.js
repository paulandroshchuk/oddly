import Dashboard from './components/entries/Dashboard.vue'
import Dictionary from './components/entries/Dictionary.vue'
import EntryType from './components/entries/EntryType.vue'
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/dictionary', component: Dictionary, name: 'dictionary.index' },
    { path: '/dictionary/:entryType', component: () => import('./components/entries/EntryType.vue'), name: 'entryType.show' },
    { path: '/entries/:entry', component: () => import('./components/entries/ViewEntry.vue'), name: 'entries.show' },
]

const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes,
})

export default router
