<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useProjectStore } from '../stores/projectStore'
import ProjectModal from '../components/ProjectModal.vue'
import { useToastStore } from '../stores/toastStore'

const projectStore = useProjectStore()
const toastStore = useToastStore()
const isModalOpen = ref(false)

onMounted(() => {
    projectStore.fetchProjects()
})

const handleCreateProject = async (projectData: { name: string, description: string }) => {
    try {
        await projectStore.createProject(projectData)
        toastStore.addToast('Projeto criado com sucesso!', 'success')
        isModalOpen.value = false
        await projectStore.fetchProjects();
    } catch (e) {
        toastStore.addToast('Erro ao criar projeto.', 'error')
    }
}

</script>

<template>
    <div class="p-8">
        <div class="flex justify-between mb-8">
            <h1 class="text-2xl font-bold">Meus Projetos</h1>
            <button @click="isModalOpen = true" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                + Novo Projeto
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <RouterLink v-for="project in projectStore.projects" :key="project.id" :to="`/projects/${project.id}`"
                class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900">{{ project.name }}</h3>
                <p class="text-gray-600 text-sm mt-2">{{ project.description }}</p>
                <span class="inline-block mt-4 text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">
                    {{ project.tasks_count }} tarefas
                </span>
            </RouterLink>
        </div>

        <ProjectModal :isOpen="isModalOpen" @close="isModalOpen = false" @save="handleCreateProject" />
    </div>
</template>