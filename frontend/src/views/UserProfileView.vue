<script setup>
  import { onMounted, computed, ref, watch } from 'vue'
  import { useRoute } from 'vue-router'
  import { useUser } from '@/composables/useUser.js'
  import { usePosts } from '@/composables/usePost.js'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs'
  import { Skeleton } from '@/components/ui/skeleton'
  import { MapPin, Calendar, Mail } from 'lucide-vue-next'
  import PostCard from '@/components/PostCard.vue'
  import EditPostDialog from '@/components/EditPostDialog.vue'

  const route = useRoute()

  const { user, loading, fetchUser, fetchMe, me } = useUser()
  const { myPosts, loading: postsLoading, fetchMyPosts, toggleLike, deletePost, updatePost } = usePosts()

  const activeTab = ref('posts')
  const editOpen = ref(false)
  const editingPost = ref(null)

  const isOwnProfile = computed(() => me.value && String(me.value.id) === String(route.params.id))
  const profileData = computed(() => isOwnProfile.value ? me.value : user.value)

  onMounted(async () => {
    await fetchMe()
    if (!isOwnProfile.value) {
      fetchUser(route.params.id)
    }
  })

  watch(isOwnProfile, (val) => {
    if (val && myPosts.value.length === 0) {
      fetchMyPosts()
    }
  }, { immediate: true })

  function handleLike(postId) {
    toggleLike(postId)
  }

  function handleEdit(post) {
    editingPost.value = post
    editOpen.value = true
  }

  async function handleDeleteMyPost(id) {
    await deletePost(id)
    myPosts.value = myPosts.value.filter(p => p.id !== id)
  }

  async function handleSavePost(id, title, content) {
    await updatePost(id, title, content)
    myPosts.value = myPosts.value.map(p => p.id === id ? { ...p, title, content } : p)
  }
</script>

<template>
  <div>
    <div v-if="loading && !profileData" class="px-4 py-6 space-y-4">
      <Skeleton class="h-32 w-full rounded-lg" />
    </div>

    <template v-else-if="profileData">
      <div class="border-b px-4 py-4">
        <div class="flex items-center gap-4">
          <Avatar class="size-16">
            <AvatarImage v-if="profileData.avatar" :src="profileData.avatar" />
            <AvatarFallback class="text-lg">
              {{ profileData.first_name?.charAt(0) }}{{ profileData.last_name?.charAt(0) }}
            </AvatarFallback>
          </Avatar>
          <div class="flex-1">
            <h2 class="text-lg font-bold">{{ profileData.name }}</h2>
            <p v-if="profileData.bio" class="text-sm text-muted-foreground mt-0.5">{{ profileData.bio }}</p>
            <div class="flex flex-wrap gap-3 text-xs text-muted-foreground mt-2">
              <div v-if="profileData.email" class="flex items-center gap-1">
                <Mail class="size-3" />
                {{ profileData.email }}
              </div>
              <div
                v-if="profileData.birthplace_city || profileData.birthplace_country"
                class="flex items-center gap-1"
              >
                <MapPin class="size-3" />
                {{ [profileData.birthplace_city, profileData.birthplace_country].filter(Boolean).join(', ') }}
              </div>
              <div v-if="profileData.created_at" class="flex items-center gap-1">
                <Calendar class="size-3" />
                Joined {{ new Date(profileData.created_at).toLocaleDateString() }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <Tabs v-model="activeTab">
        <TabsList class="w-full rounded-none border-b bg-background h-auto p-0">
          <TabsTrigger
            value="posts"
            class="flex-1 rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:shadow-none py-3"
          >
            Posts
          </TabsTrigger>
          <TabsTrigger
            value="likes"
            class="flex-1 rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:shadow-none py-3"
          >
            Likes
          </TabsTrigger>
        </TabsList>

        <TabsContent value="posts" class="mt-0">
          <template v-if="isOwnProfile">
            <div v-if="postsLoading" class="divide-y">
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
            <div v-else-if="myPosts.length === 0" class="text-center py-12 text-muted-foreground text-sm">
              Vous n'avez pas encore publié de post.
            </div>
            <div v-else>
              <PostCard
                v-for="post in myPosts"
                :key="post.id"
                :post="post"
                :current-user-id="me?.id"
                @like="handleLike"
                @delete="handleDeleteMyPost"
                @edit="handleEdit"
              />
            </div>
          </template>
          <div v-else class="text-center py-12 text-muted-foreground text-sm">
            Les posts de cet utilisateur ne sont pas disponibles.
          </div>
        </TabsContent>

        <TabsContent value="likes" class="mt-0">
          <div class="text-center py-12 text-muted-foreground text-sm">
            Les posts likés ne sont pas encore disponibles.
          </div>
        </TabsContent>
      </Tabs>

      <EditPostDialog
        v-model:open="editOpen"
        :post="editingPost"
        @save="handleSavePost"
      />
    </template>
  </div>
</template>
