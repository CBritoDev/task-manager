<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTasks } from '../composables/useTasks'
import TaskCard from '../components/TaskCard.vue'
import { debounce } from '../utils/debounce'
import { useToastStore } from '../stores/toastStore'

const toastStore = useToastStore()
const route = useRoute();
const router = useRouter();
const projectId = route.params.id as string

const { tasks, loading, error, fetchTasks, updateTask } = useTasks()

//estados dos filtros observados
const filterStatus = ref('')
const filterPriority = ref('')

const applyFilters = debounce(() => {
    fetchTasks(projectId, filterStatus.value, filterPriority.value)
}, 300)

watch([filterStatus, filterPriority], () => {
    applyFilters()
})

onMounted(() => {
    fetchTasks(projectId)
})


const onTaskStatusChange = async (taskId: number, newStatus: any) => {
    try {
        await updateTask(taskId, { status: newStatus })
        toastStore.addToast('Status atualizado com sucesso!', 'success')
    } catch (e) {
        toastStore.addToast('Erro ao atualizar status.', 'error')
    }
}

</script>

<template>
    <div class="max-w-7xl mx-auto p-6 md:p-8">
        <div class="mb-8">
            <button @click="router.push('/')"
                class="text-gray-500 hover:text-blue-600 flex items-center text-sm font-medium mb-4 transition-colors">
                <- Voltar para Projetos </button>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                        <h1 class="text-3xl font-bold text-gray-900">Tarefas do Projeto</h1>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-lg transition-colors">+
                            Nova Tarefa</button>
                    </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-8 flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                <select v-model="filterStatus"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border bg-gray-50">
                    <option value="">Todos os Status</option>
                    <option value="todo">A Fazer</option>
                    <option value="in_progress">Em Progresso</option>
                    <option value="done">Concluida</option>
                </select>
            </div>

            <div class="flex-1">
                <label
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Prioridade</label>
                <select v-model="filterPriority"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border border-gray-50">
                    <option value="">Todas as Prioridades</option>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                </select>
            </div>
        </div>

        <div v-if="loading" class="flex justify-center py-20">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        </div>

        <div v-else-if="error" class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 border border-red-200">
            {{ error }}
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid.-cols-3 gap-6">
            <TaskCard v-for="task in tasks" :key="task.id" :task="task" :onStatusChange="onTaskStatusChange" />
            < </div>
        </div>
</template>