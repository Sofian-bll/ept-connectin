import { ref } from 'vue'
import api from '@/services/api.js'

export function usePosts() {
  const posts = ref([])
  const post = ref(null)
  const myPosts = ref([])
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

  async function fetchPost(id) {
    loading.value = true
    try {
      const response = await api.get(`/posts/${id}`)
      post.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function createPost(title, content, file = null) {
    try {
      const body = new FormData()
      body.append('title', title)
      body.append('content', content)
      if (file) body.append('media', file)
      const response = await api.post('/posts', body)
      posts.value.unshift(response.data.data)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function updatePost(id, title, content) {
    try {
      const response = await api.put(`/posts/${id}`, { title, content })
      const index = posts.value.findIndex(p => p.id === id)
      if (index !== -1) {
        posts.value[index] = response.data.data
      }
      post.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function deletePost(id) {
    try {
      await api.delete(`/posts/${id}`)
      posts.value = posts.value.filter(p => p.id !== id)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function fetchMyPosts() {
    loading.value = true
    try {
      const response = await api.get('/user/posts')
      myPosts.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function toggleLike(postId) {
    try {
      const response = await api.post(`/posts/${postId}/like`)
      const index = posts.value.findIndex(p => p.id === postId)
      if (index !== -1) {
        posts.value[index].is_liked = response.data.liked
        posts.value[index].likes_count = response.data.likes_count
      }
      if (post.value && post.value.id === postId) {
        post.value.is_liked = response.data.liked
        post.value.likes_count = response.data.likes_count
      }
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  return {
    posts,
    post,
    myPosts,
    loading,
    error,
    fetchPosts,
    fetchPost,
    fetchMyPosts,
    createPost,
    updatePost,
    deletePost,
    toggleLike,
  }
}
