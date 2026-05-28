<script setup lang="ts">
import {ref,onMounted} from 'vue'
import {useProjectStore} from '../stores/projectStore'
import ProjectModal from '../components/ProjectModal.vue'
import {useToastStore} from '../stores/toastStore'

const projectStore = useProjectStore()
const toastStore = useToastStore()
const isModalOpen = ref(false)

onMounted(()=>{
    projectStore.fetchProjects()
})

const handleCreateProject = async (projectData: {name:string, description:string}) =>{
    try{
        await projectStore.createProject(projectData)
        toastStore.addToast('Projeto criado com sucesso!','success')
        isModalOpen.value = false
    }catch(e){
        toastStore.addToast('Erro ao criar projeto.','error')
    }
}

</script>

<template>
  <div class="p-8">
    <div class="flex justify-between mb-8">
      <h1 class="text-2xl font-bold">Meus Projetos</h1>
      <button 
        @click="isModalOpen = true" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg"
      >
        + Novo Projeto
      </button>
    </div>

    <ProjectModal 
      :isOpen="isModalOpen" 
      @close="isModalOpen = false" 
      @save="handleCreateProject" 
    />
  </div>
</template>