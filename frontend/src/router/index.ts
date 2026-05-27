import {createRouter, createWebHistory} from 'vue-router'
import ProjectListView from '../views/ProjectListView.vue'
import ProjectDetailView from '../views/ProjectDetailView.vue'

const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path: '/',
            name: 'ProjectList',
            component: ProjectListView
        },
        {
            path: '/projects/:id',
            name: 'ProjectDetail',
            component: ProjectDetailView
        }
    ]
})

export default router