<script setup lang="ts">
import { computed } from 'vue'
import type { Task } from '../stores/taskStore'

const props = defineProps<{
    task: Task;
    onStatusChange: (taskId: number, newStatus: Task['status']) => void;
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
            <h3 class="text-lg font-bold text-gray-800 line-clamp-1" :title="task.title">{{ task.title }}</h3>
        </div>

        <!-- Badge de Atraso--->>
        <span v-if="isOverdue"
            class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wider flex items-center whitespace-nowrap ml-2">
            Atrasada
        </span>

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

            <!-- Dropdown de Status  -->
            <select :value="task.status" @change="handleStatusChange"
                class="text-sm border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 px-2 cursor-pointer bg-gray-50 font-medium outline-none">
                <option value="todo">A Fazer</option>
                <option value="in_progress">Em Progresso</option>
                <option value="done">Concluída</option>
            </select>
        </div>
    </div>
</template>