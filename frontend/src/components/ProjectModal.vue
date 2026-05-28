<script setup lang="ts">
import { ref } from 'vue'

const props = defineProps<{ isOpen: boolean }>()
const emit = defineEmits(['close', 'save'])

const name = ref('')
const description = ref('')

const save = () => {
    emit('save', { name: name.value, description: description.value })
    name.value = ''
    description.value = ''
    emit('close')
}
</script>

<template>
    <Transition name="fade">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="$emit('close')"></div>

            <div class="relative bg-white rounded-xl shadow-2xl p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Novo Projeto</h2>

                <div class="space-y-4">
                    <input v-model="name" placeholder="Nome do projeto" class="w-full border rounded-lg p-2" />
                    <textarea v-model="description" placeholder="Descrição" class="w-full border rounded-lg p-2"
                        rows="3"></textarea>
                </div>

                <<div class="flex justify-end gap-3 mt-6">
                    <button @click="$emit('close')"
                        class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg cursor-pointer transition-colors font-medium">
                        Cancelar
                    </button>
                    <button @click="save"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer transition-colors font-medium shadow-sm">
                        Criar Projeto
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