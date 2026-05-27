import {defineStore} from 'pinia'
import {api} from '.../services/api'

export interface Project{
    id:number;
    name:string;
    description:string;
    status: 'active' | 'archived';
    tasks_count?:number;
}

export const useProjectStore = defineStore('project',{
    state:() => ({
        projects: [] as Project[],
        loading:false,
        error: null as string|null,
    }),
    actions:{
        async fetchProjects(){
            this.loading = true;
            this.error = null;
            try{
                const response = await api.get('/projects');
                this.projects = response.data.data;
            }catch(err:any){
                this.error = err.response?.data?.message || 'Erro ao carregar projetos';
            }finally{
                this.loading = false;
            }
        },
        async createProject(payload:{name:string;description:string}){
            this.loading=true;
            this.error=null;
            try{
                const response = await api.post('/projects',payload);
                this.projects.unshift(response.data.data);
            }catch(err:any){
                this.error = err.response?.data?.message || 'Erro ao criar projeto';
                throw err;
            }finnaly{
                this.loading =false;
            }
        }
    }
})