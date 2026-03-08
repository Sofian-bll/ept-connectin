import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api.js'

export function useAuth() {
  const loading = ref(false)
  const error = ref(null)
  const user = ref(null)
  const router = useRouter()

  async function login(email, password) {
    loading.value = true

    try {
      const response = await api.post('/login', { email, password })
      localStorage.setItem('token', response.data.token)
      await router.push('/feed')
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function register(
    first_name,
    last_name,
    name,
    email,
    password,
    password_confirmation
  ) {
    loading.value = true

    try {
      const response = await api.post('/register', {
        first_name,
        last_name,
        name,
        email,
        password,
        password_confirmation,
      })
      localStorage.setItem('token', response.data.token)
      await router.push('/feed')
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    loading.value = true
    try {
      await api.post('/logout')
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      localStorage.removeItem('token')
      await router.push('/login')
      loading.value = false
    }
  }

  return { loading, error, user, login, register, logout }
}
