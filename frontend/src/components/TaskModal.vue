<script setup lang="ts">
import { ref } from 'vue'
defineProps<{ isOpen: boolean; projectId: string; isSaving?: boolean }>()
const emit = defineEmits(['close', 'save'])

const title = ref('')
const description = ref('')
const status = ref('todo')
const priority = ref('medium')
const due_date = ref('')

const save = () => {
    emit('save', {
        title: title.value,
        description: description.value,
        status: status.value,
        priority: priority.value,
        due_date: due_date.value
    })
    emit('close')
}
</script>

<template>
    <Transition name="fade">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" @click="$emit('close')"></div>
            <div class="relative bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                <h2 class="text-xl font-bold mb-4">Nova Tarefa</h2>
                <input v-model="title" placeholder="Título" class="w-full border p-2 mb-2 rounded" />
                <textarea v-model="description" placeholder="Descrição"
                    class="w-full border p-2 mb-2 rounded"></textarea>
                <input v-model="due_date" type="date" class="w-full border p-2 mb-2 rounded" />
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="$emit('close')"
                        class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg cursor-pointer transition-colors font-medium">
                        Cancelar
                    </button>
                    <button @click="save" :disabled="isSaving"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all shadow-sm disabled:opacity-70 disabled:cursor-not-allowed">
                        <span v-if="isSaving"
                            class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        {{ isSaving ? 'Criando...' : 'Criar Tarefa' }}
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>