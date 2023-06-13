// import {createRouter, createWebHashHistory} from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router';
export const router = createRouter({
    history: createWebHistory(),
    routes: [
        // {path: '/:pathMatch(.*)*', component: () => import('./components/NotfoundComponent.vue')},
        // {path: '/', component: () => import('./components/ShowInfo.vue')},
        {path: '/', component: () => import('./components/Home.vue')},
        {path: '/:allComponent', component: () => import('./components/AllComponent.vue')},
        {path: '/search/:data', component: () => import('./components/SearchComponent.vue')},


        {path: '/add-new-component', component: () => import('./components/AddNewComponent.vue')},
        


        // {path: '/Test', component: () => import('./pages/Test.vue')},
        // {path: '/tashur', component: () => import('./pages/tashur.vue')},
        // {path: '/egzon', component: () => import('./pages/Egzon.vue')},
        // {path: '/ilir', component: () => import('./pages/Ilir.vue')},
    ]
})
