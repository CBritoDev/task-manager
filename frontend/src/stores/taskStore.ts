import { defineStore } from 'pinia'
import { api } from '../services/api'

export interface Task {
    id: number;
    project_id: number;
    title: string;
    description: string;
    status: 'todo' | 'in_progress' | 'done';
    priority: 'low' | 'medium' | 'high';
    due_date: string;
}

export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [] as Task[],
        loading: false,
        error: null as string | null,
    }),
    actions: {
        async fetchTasks(projectId: string | number, status?: string, priority?: string) {
            this.loading = true;
            this.error = null;

            try {
                let url = `/projects/${projectId}/tasks`;
                const params = new URLSearchParams();
                if (status) params.append('status', status);
                if (priority) params.append('priority', priority);
                if (params.toString()) url += `?${params.toString()}`;

                const response = await api.get(url);
                this.tasks = response.data.data;
            } catch (err: any) {
                this.error = err.response?.data?.message || 'Erro ao carregar tarefas';
            } finally {
                this.loading = false;
            }
        },

        async createTask(projectId: string | number, payload: Partial<Task>) {
            this.loading = true;
            this.error = null;
            try {
                const response = await api.post(`/projects/${projectId}/tasks`, payload);
                this.tasks.unshift(response.data.data);
            } catch (err: any) {
                this.error = err.response?.data?.message || 'Erro ao criar tarefa';
                throw err;
            } finally {
                this.loading = false;
            }
        },

        async updateTask(taskId: number, payload: Partial<Task>) {

            const index = this.tasks.findIndex(t => t.id === taskId);
            if (index === -1) return;

            const previousTaskState = { ...this.tasks[index] };

            this.tasks[index] = { ...this.tasks[index],...payload };
            try {
                const response = await api.patch(`/tasks/${taskId}`, payload);

                this.tasks[index] = response.data.data;
            } catch (err: any) {

                this.tasks[index] = previousTaskState;

                this.error = err.response?.data?.message || 'Erro ao atualizar tarefa. Alteração revertida.';
                throw err;
            }


        },
        async deleteTask(taskId: number) {
            try {
                await api.delete(`/tasks/${taskId}`);
                this.tasks = this.tasks.filter(t => t.id !== taskId);
            } catch (err: any) {
                this.error = err.response?.data?.message || 'Erro ao deletar tarefa';
                throw err;
            }
        }
    }
})