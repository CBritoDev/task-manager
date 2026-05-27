import { storeToRefs } from 'pinia'
import { useProjectStore} from '../stores/projectStore'

export function useProjects(){
    const store = useProjectStore();

    const { projects, loading, error} = storeToRefs(store)

    return {
        projects,
        loading,
        error,
        fetchProjects: store.fetchProjects,
        createProject: store.createProject
    }
}