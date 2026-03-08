import { ref } from 'vue'
import api from '@/services/api.js'

export function useComments(postId) {
  const comments = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchComments() {
    loading.value = true
    try {
      const response = await api.get(`/posts/${postId}/comments`)
      comments.value = response.data.data
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    } finally {
      loading.value = false
    }
  }

  async function createComment(content) {
    try {
      const response = await api.post(`/posts/${postId}/comments`, { content })
      comments.value.unshift(response.data.data)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function updateComment(commentId, content) {
    try {
      const response = await api.put(`/posts/${postId}/comments/${commentId}`, { content })
      const index = comments.value.findIndex(c => c.id === commentId)
      if (index !== -1) {
        comments.value[index] = response.data.data
      }
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  async function deleteComment(commentId) {
    try {
      await api.delete(`/posts/${postId}/comments/${commentId}`)
      comments.value = comments.value.filter(c => c.id !== commentId)
    } catch (e) {
      error.value = e.response?.data?.message ?? e.message
    }
  }

  return { comments, loading, error, fetchComments, createComment, updateComment, deleteComment }
}
