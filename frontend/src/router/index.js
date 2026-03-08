import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import FeedView from '@/views/FeedView.vue'
import PostView from '@/views/PostView.vue'
import ProfileView from '@/views/ProfileView.vue'
import UserProfileView from '@/views/UserProfileView.vue'

const publicRoutes = ['/login', '/register']

const routes = [
  {
    path: '/',
    redirect: '/feed',
  },
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
  {
    path: '/posts/:id',
    component: PostView,
  },
  {
    path: '/profile',
    component: ProfileView,
  },
  {
    path: '/users/:id',
    component: UserProfileView,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to) => {
  const token = localStorage.getItem('token')
  const isPublic = publicRoutes.includes(to.path)

  if (!isPublic && !token) {
    return '/login'
  }
})

export default router
