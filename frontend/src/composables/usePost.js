import { ref } from 'vue'
import api from '@/services/api.js'

export function usePosts() {
  const posts = ref([])
  const post = ref(null)
  const myPosts = ref([])
  const userPosts = ref([])
  const likedPosts = ref([])
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

  async function fetchUserPosts(userId) {
    loading.value = true
    try {
      const response = await api.get(`/users/${userId}/posts`)
      userPosts.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function fetchLikedPosts(userId) {
    loading.value = true
    try {
      const response = await api.get(`/users/${userId}/liked-posts`)
      likedPosts.value = response.data.data
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
      const updated = response.data.data
      const replaceIn = (list) => {
        const index = list.findIndex(p => p.id === id)
        if (index !== -1) list[index] = updated
      }
      replaceIn(posts.value)
      replaceIn(myPosts.value)
      replaceIn(userPosts.value)
      if (post.value?.id === id) post.value = updated
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function deletePost(id) {
    try {
      await api.delete(`/posts/${id}`)
      const removeFrom = (list) => list.filter(p => p.id !== id)
      posts.value = removeFrom(posts.value)
      myPosts.value = removeFrom(myPosts.value)
      userPosts.value = removeFrom(userPosts.value)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function toggleLike(postId) {
    try {
      const response = await api.post(`/posts/${postId}/like`)
      const update = (list) => {
        const index = list.findIndex(p => p.id === postId)
        if (index !== -1) {
          list[index].is_liked = response.data.liked
          list[index].likes_count = response.data.likes_count
        }
      }
      update(posts.value)
      update(myPosts.value)
      update(userPosts.value)
      update(likedPosts.value)
      if (post.value?.id === postId) {
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
    userPosts,
    likedPosts,
    loading,
    error,
    fetchPosts,
    fetchPost,
    fetchMyPosts,
    fetchUserPosts,
    fetchLikedPosts,
    createPost,
    updatePost,
    deletePost,
    toggleLike,
  }
}
