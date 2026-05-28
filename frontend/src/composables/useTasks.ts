import { storeToRefs } from 'pinia'
import { useTaskStore } from '../stores/taskStore'

export function useTasks(){
    const store = useTaskStore()
    const {tasks,loading,error} = storeToRefs(store)

    return{
        tasks,
        loading,
        error,
        fetchTasks: store.fetchTasks,
        createTask: store.createTask,
        updateTask: store.updateTask,
        deleteTask: store.deleteTask
    }
}

