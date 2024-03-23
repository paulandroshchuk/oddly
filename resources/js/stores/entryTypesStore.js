import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useEntryTypesStore = defineStore('entries', () => {
    const loading = ref(false);
    const error = ref(null);
    const entryTypes = ref(null);

    function loadEntryTypes() {
        if (loading.value) return;

        loading.value = true;

        axios
            .get('/api/entry-types')
            .then(response => {
                entryTypes.value = response.data.data;
            })
            .catch(e => {
                error.value = true;

                throw e;
            })
            .finally(() => {
                loading.value = false;
            })
    }

    return {
        loading,
        error,
        entryTypes,
        loadEntryTypes,
    }
});
