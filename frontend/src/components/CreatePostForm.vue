<script setup>
  import { ref } from 'vue'
  import { Button } from '@/components/ui/button'
  import { Input } from '@/components/ui/input'
  import { Textarea } from '@/components/ui/textarea'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Separator } from '@/components/ui/separator'

  const props = defineProps({
    currentUser: { type: Object, required: false },
  })

  const emit = defineEmits(['submit'])

  const title = ref('')
  const content = ref('')

  function handleSubmit() {
    if (!title.value.trim() || !content.value.trim()) return
    emit('submit', title.value, content.value)
    title.value = ''
    content.value = ''
  }
</script>

<template>
  <div class="border-b">
    <form @submit.prevent="handleSubmit" class="px-4 py-3">
      <div class="flex gap-3">
        <Avatar class="size-10 shrink-0">
          <AvatarImage v-if="currentUser?.avatar" :src="currentUser.avatar" />
          <AvatarFallback>
            {{ currentUser?.first_name?.charAt(0) }}{{ currentUser?.last_name?.charAt(0) }}
          </AvatarFallback>
        </Avatar>
        <div class="flex-1 space-y-2">
          <Input
            v-model="title"
            placeholder="Title"
            class="border-0 px-0 text-base font-medium shadow-none focus-visible:ring-0"
            required
          />
          <Textarea
            v-model="content"
            placeholder="What's happening?"
            class="border-0 px-0 text-base shadow-none focus-visible:ring-0 resize-none min-h-[60px]"
            rows="2"
            required
          />
        </div>
      </div>
      <Separator class="my-3" />
      <div class="flex justify-end">
        <Button
          type="submit"
          size="sm"
          class="rounded-full px-5"
        >
          Post
        </Button>
      </div>
    </form>
  </div>
</template>
