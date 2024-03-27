import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import PasswordView from '@/views/PasswordView.vue'
import ForgotView from '@/views/ForgotView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/password',
      name: 'password',
      component: PasswordView
    },
    {
      path: '/forgot',
      name: 'forgot',
      component: ForgotView
    },
  ]
})

export default router
