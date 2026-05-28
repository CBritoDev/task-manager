<script setup lang="ts">
import { ref } from 'vue'
defineProps<{ isOpen: boolean; projectId: string }>()
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
        status: status.value, priority: 
        priority.value, 
        due_date: due_date.value })
    emit('close')
}
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="$emit('close')"></div>
        <div class="relative bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
            <h2 class="text-xl font-bold mb-4">Nova Tarefa</h2>
            <input v-model="title" placeholder="Título" class="w-full border p-2 mb-2 rounded" />
            <textarea v-model="description" placeholder="Descrição" class="w-full border p-2 mb-2 rounded"></textarea>
            <input v-model="due_date" type="date" class="w-full border p-2 mb-2 rounded" />
            <div class="flex justify-end gap-2 mt-4">
                <button @click="$emit('close')" class="px-4 py-2">Cancelar</button>
                <button @click="save" class="bg-blue-600 text-white px-4 py-2 rounded">Criar Tarefa</button>
            </div>
        </div>
    </div>
</template>