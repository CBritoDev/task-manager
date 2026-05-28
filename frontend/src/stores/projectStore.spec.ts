import { setActivePinia, createPinia } from 'pinia';
import { useProjectStore } from './projectStore';
import { describe, it, expect, vi, beforeEach } from 'vitest';
import { api } from '../services/api';

vi.mock('../services/api', () =>{
    return{
        api: {
            get: vi.fn(),
            post: vi.fn()
        }
    };
});

describe('Project Store',()=>{
    beforeEach(()=>{
        setActivePinia(createPinia())
        vi.clearAllMocks()
    })

    it('popula o estado de projetos quando o fetchProject tem sucesso',async ()=>{
        const store = useProjectStore();
        const mockProjects = [{ id:1, name:'Projeto Teste', description: 'Teste'}];

        //simula sucesso ao obter dados
        (api.get as any).mockResolvedValue({data: {data : mockProjects}});

        await store.fetchProjects()

        expect(store.projects).toEqual(mockProjects);
        expect(store.loading).toBe(false);
        expect(api.get).toHaveBeenCalledWith('/projects');
    })

    it('seta mensagem de erro quando fetchProjects falha',async () =>{
        const store = useProjectStore();

        //simula falha
        (api.get as any).mockRejectedValue(new Error('Erro de rede'));

        await store.fetchProjects();

        expect(store.error).toBe('Erro ao carregar projetos')
        expect(store.loading).toBe(false)
    })
})