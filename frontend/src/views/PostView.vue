<script setup>
  import { onMounted, ref } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import { usePosts } from '@/composables/usePost.js'
  import { useComments } from '@/composables/useComments.js'
  import { useUser } from '@/composables/useUser.js'
  import PostCard from '@/components/PostCard.vue'
  import EditPostDialog from '@/components/EditPostDialog.vue'
  import CommentItem from '@/components/CommentItem.vue'
  import CommentForm from '@/components/CommentForm.vue'
  import { Skeleton } from '@/components/ui/skeleton'
  import { Separator } from '@/components/ui/separator'
  import { Button } from '@/components/ui/button'
  import { ArrowLeft } from 'lucide-vue-next'

  const route = useRoute()
  const router = useRouter()
  const postId = route.params.id

  const { post, loading: postLoading, fetchPost, updatePost, deletePost, toggleLike } = usePosts()
  const { comments, loading: commentsLoading, fetchComments, createComment, deleteComment } = useComments(postId)
  const { me, fetchMe } = useUser()

  const editOpen = ref(false)
  const editingPost = ref(null)

  onMounted(() => {
    fetchPost(postId)
    fetchComments()
    fetchMe()
  })

  function handleLike(postId) {
    toggleLike(postId)
  }

  function handleEdit(p) {
    editingPost.value = p
    editOpen.value = true
  }

  function handleSave(id, title, content) {
    updatePost(id, title, content)
  }

  function handleDeletePost(id) {
    deletePost(id)
  }

  async function handleCreateComment(content) {
    await createComment(content)
    if (post.value) {
      post.value.comments_count = (post.value.comments_count || 0) + 1
    }
  }

  async function handleDeleteComment(commentId) {
    await deleteComment(commentId)
    if (post.value) {
      post.value.comments_count = Math.max(0, (post.value.comments_count || 0) - 1)
    }
  }
</script>

<template>
  <div>
    <div class="sticky top-0 z-10 flex items-center gap-4 border-b bg-background/80 backdrop-blur px-4 h-14">
      <Button variant="ghost" size="icon-sm" class="rounded-full" @click="router.back()">
        <ArrowLeft class="size-5" />
      </Button>
      <h1 class="text-lg font-bold">Post</h1>
    </div>

    <div v-if="postLoading" class="px-4 py-3 space-y-3">
      <div class="flex gap-3">
        <Skeleton class="size-10 rounded-full" />
        <div class="flex-1 space-y-2">
          <Skeleton class="h-4 w-32" />
          <Skeleton class="h-4 w-full" />
          <Skeleton class="h-20 w-full" />
        </div>
      </div>
    </div>

    <template v-else-if="post">
      <PostCard
        :post="post"
        :current-user-id="me?.id"
        @like="handleLike"
        @delete="handleDeletePost"
        @edit="handleEdit"
      />

      <div class="border-b px-4 py-3">
        <CommentForm :current-user="me" @submit="handleCreateComment" />
      </div>

      <div v-if="commentsLoading" class="px-4 py-3 space-y-3">
        <Skeleton class="h-10 w-full" />
        <Skeleton class="h-10 w-full" />
      </div>

      <div v-else-if="comments.length === 0" class="text-center py-8 text-sm text-muted-foreground">
        No comments yet.
      </div>

      <div v-else class="divide-y">
        <div v-for="comment in comments" :key="comment.id" class="px-4">
          <CommentItem
            :comment="comment"
            :current-user-id="me?.id"
            @delete="handleDeleteComment"
          />
        </div>
      </div>
    </template>

    <EditPostDialog
      v-model:open="editOpen"
      :post="editingPost"
      @save="handleSave"
    />
  </div>
</template>
