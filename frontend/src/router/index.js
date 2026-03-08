// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '@/views/LoginView.vue'
import FeedView from '@/views/FeedView.vue'
import RegisterView from '@/views/RegisterView.vue'

const publicRoutes = ['/login', '/register']

const routes = [
  {
    path: '/login',
    component: LoginView,
  },
  {
    path: '/register',
    component: RegisterView,
  },
  {
    path: '/feed',
    component: FeedView,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(to => {
  const token = localStorage.getItem('token')
  const isPublic = publicRoutes.includes(to.path)

  if (!isPublic && !token) {
    return '/login'
  }
})

export default router
