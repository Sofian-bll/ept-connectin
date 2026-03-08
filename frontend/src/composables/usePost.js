import { ref } from 'vue'
import api from '@/services/api.js'

export function usePosts() {
  const posts = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchPosts() {
    loading.value = true
    try {
      const response = await api.get('/posts')
      posts.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function createPost(content) {
    try {
      const response = await api.post('/posts', { content })
      posts.value.unshift(response.data.data)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function toggleLike(postId) {
    try {
      const response = await api.post(`/posts/${postId}/like`)
      const index = posts.value.findIndex(p => p.id === postId)
      if (index !== -1) {
        posts.value[index] = response.data.data
      }
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  return { posts, loading, error, fetchPosts, createPost, toggleLike }
}
