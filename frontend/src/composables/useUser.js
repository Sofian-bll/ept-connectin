import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api.js'

export function useUser() {
  const me = ref(null)
  const user = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const router = useRouter()

  async function fetchMe() {
    loading.value = true
    try {
      const response = await api.get('/user')
      me.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function fetchUser(id) {
    loading.value = true
    try {
      const response = await api.get(`/users/${id}`)
      user.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function updateProfile(data, avatarFile = null) {
    loading.value = true
    try {
      let response
      if (avatarFile) {
        const formData = new FormData()
        Object.entries(data).forEach(([key, val]) => {
          if (val !== null && val !== undefined) formData.append(key, val)
        })
        formData.append('avatar', avatarFile)
        formData.append('_method', 'PUT')
        response = await api.post('/user', formData)
      } else {
        response = await api.put('/user', data)
      }
      me.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function updatePassword(current_password, password, password_confirmation) {
    loading.value = true
    try {
      await api.put('/user/password', {
        current_password,
        password,
        password_confirmation,
      })
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function deleteAccount(strategy) {
    loading.value = true
    try {
      await api.delete(`/user?strategy=${strategy}`)
      localStorage.removeItem('token')
      await router.push('/login')
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  return { me, user, loading, error, fetchMe, fetchUser, updateProfile, updatePassword, deleteAccount }
}
