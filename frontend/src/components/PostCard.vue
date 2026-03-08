<script setup>
  import { useRouter } from 'vue-router'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Button } from '@/components/ui/button'
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu'
  import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
  } from '@/components/ui/tooltip'
  import {
    Heart,
    MessageCircle,
    MoreHorizontal,
    Pencil,
    Trash2,
  } from 'lucide-vue-next'

  const router = useRouter()

  const props = defineProps({
    post: { type: Object, required: true },
    currentUserId: { type: Number, required: false },
  })

  const emit = defineEmits(['like', 'delete', 'edit'])

  function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    if (seconds < 60) return 'now'
    const minutes = Math.floor(seconds / 60)
    if (minutes < 60) return `${minutes}m`
    const hours = Math.floor(minutes / 60)
    if (hours < 24) return `${hours}h`
    const days = Math.floor(hours / 24)
    if (days < 7) return `${days}d`
    return new Date(date).toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
    })
  }
</script>

<template>
  <article class="border-b px-4 py-3 hover:bg-accent/30 transition-colors">
    <div class="flex gap-3">
      <Avatar
        class="size-10 cursor-pointer shrink-0"
        @click="router.push(`/users/${post.author?.id}`)"
      >
        <AvatarImage v-if="post.author?.avatar" :src="post.author.avatar" />
        <AvatarFallback>
          {{ post.author?.first_name?.charAt(0)
          }}{{ post.author?.last_name?.charAt(0) }}
        </AvatarFallback>
      </Avatar>

      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-1">
          <span
            class="text-sm font-bold cursor-pointer hover:underline truncate"
            @click="router.push(`/users/${post.author?.id}`)"
          >
            {{ post.author?.name }}
          </span>
          <TooltipProvider>
            <Tooltip>
              <TooltipTrigger as-child>
                <span class="text-sm text-muted-foreground shrink-0">
                  · {{ timeAgo(post.created_at) }}
                </span>
              </TooltipTrigger>
              <TooltipContent>
                {{ new Date(post.created_at).toLocaleString() }}
              </TooltipContent>
            </Tooltip>
          </TooltipProvider>
          <div class="ml-auto">
            <DropdownMenu v-if="currentUserId === post.author?.id">
              <DropdownMenuTrigger as-child>
                <Button
                  variant="ghost"
                  size="icon-sm"
                  class="size-8 rounded-full"
                >
                  <MoreHorizontal class="size-4" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end">
                <DropdownMenuItem @click="emit('edit', post)">
                  <Pencil class="size-4" />
                  Edit
                </DropdownMenuItem>
                <DropdownMenuItem
                  class="text-destructive"
                  @click="emit('delete', post.id)"
                >
                  <Trash2 class="size-4" />
                  Delete
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </div>

        <div class="cursor-pointer" @click="router.push(`/posts/${post.id}`)">
          <h3 v-if="post.title" class="font-bold mt-0.5">
            {{ post.title }}
          </h3>
          <p class="text-sm whitespace-pre-wrap mt-1">{{ post.content }}</p>
          <img
            v-if="post.media_url"
            :src="post.media_url"
            :alt="post.title"
            class="rounded-2xl w-full object-cover max-h-96 mt-3 border"
          />
        </div>

        <div class="flex gap-6 mt-3 -ml-2">
          <Button
            variant="ghost"
            size="sm"
            class="gap-1.5 text-muted-foreground hover:text-blue-500 rounded-full"
            @click="router.push(`/posts/${post.id}`)"
          >
            <MessageCircle class="size-4" />
            <span v-if="post.comments_count">{{ post.comments_count }}</span>
          </Button>
          <TooltipProvider>
            <Tooltip>
              <TooltipTrigger as-child>
                <Button
                  variant="ghost"
                  size="sm"
                  class="gap-1.5 rounded-full"
                  :class="
                    post.is_liked
                      ? 'text-red-500 hover:text-red-600'
                      : 'text-muted-foreground hover:text-red-500'
                  "
                  @click="emit('like', post.id)"
                >
                  <Heart
                    class="size-4"
                    :fill="post.is_liked ? 'currentColor' : 'none'"
                  />
                  <span v-if="post.likes_count">{{ post.likes_count }}</span>
                </Button>
              </TooltipTrigger>
              <TooltipContent>
                {{ post.is_liked ? 'Unlike' : 'Like' }}
              </TooltipContent>
            </Tooltip>
          </TooltipProvider>
        </div>
      </div>
    </div>
  </article>
</template>
