import {createRouter, createWebHistory} from 'vue-router';

const routes = [
    {path: '/', name: 'Home', component: ()=> import('../components/HomeComp.vue')},
    {path: '/about', name: 'About', component: ()=> import('../components/AboutComp.vue')},
    {path: '/contact', name: 'Contact', component: ()=> import('../components/ContactComp.vue')},

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;