<script setup lang="ts">
import {useToastStore} from '../stores/toastStore'

const toastStore = useToastStore()
</script>

<template>
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-2">
        <div
            v-for="toast in toastStore.toasts"
            :key="toast.id"
            class="px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all"
            :class="toast.type ==='success' ? 'bg-green-600' : 'bg-red-600'"    
        >
        {{toast.message}}
        </div>
    </div>
</template>