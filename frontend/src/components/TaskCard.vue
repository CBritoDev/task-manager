<script setup lang="ts">
import { computed } from 'vue'
import type { Task } from '../stores/taskStore'

const props = defineProps<{
    task: Task;
    onStatusChange: (taskId: number, newStatus: Task['status']) => void;
    onDelete: (taskId: number) => void;
}>()

const isOverdue = computed(() => {
    if (props.task.status === 'done' || !props.task.due_date) return false;
    const today = new Date().toISOString().split('T')[0];
    return props.task.due_date < today;
})

const handleStatusChange = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    props.onStatusChange(props.task.id, target.value as Task['status']);
}

const priorityColors = {
    low: 'bg-blue-100 text-blue-700',
    medium: 'bg-yellow-100 text-yellow-700',
    high: 'bg-orange-100 text-orange-700'
}

const priorityLabels = {
    low: 'Baixa',
    medium: 'Média',
    high: 'Alta'
}
</script>

<template>
    <div class="bg-white border rounded-xl p-5 transition-all flex flex-col h-full"
        :class="isOverdue ? 'border-red-400 shadow-sm shadow-red-100' : 'border-gray-200 shadow-sm hover:shadow-md'">
        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-bold text-gray-800 line-clamp-1" :title="task.title">{{ task.title }}</h3>
                <!-- Badge de Atraso -->
                <span v-if="isOverdue"
                    class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wider flex items-center whitespace-nowrap">
                    Atrasada
                </span>
            </div>

            <!-- Botão de Deletar -->
            <button @click="onDelete(task.id)"
                class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer p-1 rounded-md hover:bg-red-50"
                title="Excluir tarefa">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </div>

        <p class="text-gray-600 text-sm mb-5 flex-grow line-clamp-2">
            {{ task.description }}
        </p>

        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
            <div class="flex gap-2 items-center">
                <!-- Badge de Prioridade -->
                <span class="text-xs px-2 py-1 rounded font-semibold" :class="priorityColors[task.priority]">
                    {{ priorityLabels[task.priority] }}
                </span>

                <span class="text-xs text-gray-500 font-medium" :class="{ 'text-red-600 font-bold': isOverdue }">
                    📅 {{ task.due_date }}
                </span>
            </div>


            <select :value="task.status" @change="handleStatusChange"
                class="text-sm border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 px-2 cursor-pointer bg-gray-50 font-medium outline-none">
                <option value="todo">A Fazer</option>
                <option value="in_progress">Em Progresso</option>
                <option value="done">Concluída</option>
            </select>
        </div>
    </div>
</template>