<script setup>
  import { onMounted, ref } from 'vue'
  import { usePosts } from '@/composables/usePost.js'
  import { useUser } from '@/composables/useUser.js'
  import PostCard from '@/components/PostCard.vue'
  import CreatePostForm from '@/components/CreatePostForm.vue'
  import EditPostDialog from '@/components/EditPostDialog.vue'
  import { Skeleton } from '@/components/ui/skeleton'

  const { posts, loading, fetchPosts, createPost, updatePost, deletePost, toggleLike } = usePosts()
  const { me, fetchMe } = useUser()

  const editOpen = ref(false)
  const editingPost = ref(null)

  onMounted(() => {
    fetchPosts()
    fetchMe()
  })

  function handleCreate(title, content) {
    createPost(title, content)
  }

  function handleEdit(post) {
    editingPost.value = post
    editOpen.value = true
  }

  function handleSave(id, title, content) {
    updatePost(id, title, content)
  }

  function handleDelete(id) {
    deletePost(id)
  }

  function handleLike(postId) {
    toggleLike(postId)
  }
</script>

<template>
  <div>
    <CreatePostForm :current-user="me" @submit="handleCreate" />

    <div v-if="loading" class="divide-y">
      <div v-for="i in 3" :key="i" class="px-4 py-3 space-y-3">
        <div class="flex gap-3">
          <Skeleton class="size-10 rounded-full shrink-0" />
          <div class="flex-1 space-y-2">
            <Skeleton class="h-4 w-32" />
            <Skeleton class="h-4 w-full" />
            <Skeleton class="h-4 w-3/4" />
          </div>
        </div>
      </div>
    </div>

    <div v-else-if="posts.length === 0" class="text-center py-12 text-muted-foreground">
      No posts yet. Be the first to post!
    </div>

    <div v-else>
      <PostCard
        v-for="post in posts"
        :key="post.id"
        :post="post"
        :current-user-id="me?.id"
        @like="handleLike"
        @delete="handleDelete"
        @edit="handleEdit"
      />
    </div>

    <EditPostDialog
      v-model:open="editOpen"
      :post="editingPost"
      @save="handleSave"
    />
  </div>
</template>
