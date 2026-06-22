<script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Button } from '@/components/ui/button'
  import { Textarea } from '@/components/ui/textarea'
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu'
  import { MoreHorizontal, Trash2, Pencil } from 'lucide-vue-next'

  const router = useRouter()

  const props = defineProps({
    comment: { type: Object, required: true },
    currentUserId: { type: Number, required: false },
  })

  const emit = defineEmits(['delete', 'edit'])

  const editing = ref(false)
  const editContent = ref('')

  function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000)
    if (seconds < 60) return 'à l\'instant'
    const minutes = Math.floor(seconds / 60)
    if (minutes < 60) return `il y a ${minutes}m`
    const hours = Math.floor(minutes / 60)
    if (hours < 24) return `il y a ${hours}h`
    const days = Math.floor(hours / 24)
    if (days < 30) return `il y a ${days}j`
    return new Date(date).toLocaleDateString('fr-FR')
  }

  function handleStartEdit() {
    editContent.value = props.comment.content
    editing.value = true
  }

  function handleCancelEdit() {
    editing.value = false
    editContent.value = ''
  }

  function handleSaveEdit() {
    if (!editContent.value.trim()) return
    emit('edit', props.comment.id, editContent.value.trim())
    editing.value = false
    editContent.value = ''
  }
</script>

<template>
  <div class="flex gap-3 py-3">
    <Avatar
      class="size-8 cursor-pointer"
      @click="router.push(`/users/${comment.author?.id}`)"
    >
      <AvatarImage v-if="comment.author?.avatar" :src="comment.author.avatar" />
      <AvatarFallback class="text-xs">
        {{ comment.author?.first_name?.charAt(0) }}{{ comment.author?.last_name?.charAt(0) }}
      </AvatarFallback>
    </Avatar>
    <div class="flex-1">
      <div class="flex items-center gap-2">
        <span
          class="text-sm font-medium cursor-pointer hover:underline"
          @click="router.push(`/users/${comment.author?.id}`)"
        >
          {{ comment.author?.name }}
        </span>
        <span class="text-xs text-muted-foreground">
          {{ timeAgo(comment.created_at) }}
        </span>
        <DropdownMenu v-if="currentUserId === comment.author?.id">
          <DropdownMenuTrigger as-child>
            <Button variant="ghost" size="icon-sm" class="ml-auto size-6">
              <MoreHorizontal class="size-3" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem @click="handleStartEdit">
              <Pencil class="size-4" />
              Modifier
            </DropdownMenuItem>
            <DropdownMenuItem
              class="text-destructive"
              @click="emit('delete', comment.id)"
            >
              <Trash2 class="size-4" />
              Supprimer
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>

      <template v-if="editing">
        <Textarea
          v-model="editContent"
          class="mt-2 text-sm resize-none min-h-[60px]"
          rows="2"
          autofocus
        />
        <div class="flex gap-2 mt-2">
          <Button size="sm" @click="handleSaveEdit">Enregistrer</Button>
          <Button size="sm" variant="ghost" @click="handleCancelEdit">Annuler</Button>
        </div>
      </template>
      <p v-else class="text-sm mt-1 whitespace-pre-wrap">{{ comment.content }}</p>
    </div>
  </div>
</template>
