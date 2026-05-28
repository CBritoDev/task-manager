import {defineStore} from 'pinia'
import {ref} from 'vue'

export type Toast = { id: number; message:string;type:'success' | 'error'}

export const useToastStore = defineStore('toast',()=>{
    const toast = ref<Toast[]>([])

    const addToast = (message:string,type:'success'|'error' = 'success')=>{
        const id = Date.now()
        toasts.value.push({id,message,type})

        setTimout(()=>{
            toasts.value = toast.value.filter(t=>t.id != id)
        },3000)
    }

    return {toasts,addToast}
})