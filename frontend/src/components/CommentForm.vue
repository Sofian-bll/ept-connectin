<script setup>
  import { ref } from 'vue'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Button } from '@/components/ui/button'
  import { Textarea } from '@/components/ui/textarea'
  import { Send } from 'lucide-vue-next'

  const props = defineProps({
    currentUser: { type: Object, required: false },
  })

  const emit = defineEmits(['submit'])

  const content = ref('')

  function handleSubmit() {
    if (!content.value.trim()) return
    emit('submit', content.value)
    content.value = ''
  }
</script>

<template>
  <form @submit.prevent="handleSubmit" class="flex items-start gap-3 pt-3">
    <Avatar class="size-8">
      <AvatarImage v-if="currentUser?.avatar" :src="currentUser.avatar" />
      <AvatarFallback class="text-xs">
        {{ currentUser?.first_name?.charAt(0) }}{{ currentUser?.last_name?.charAt(0) }}
      </AvatarFallback>
    </Avatar>
    <div class="flex-1 flex gap-2">
      <Textarea
        v-model="content"
        placeholder="Écrire un commentaire..."
        rows="1"
        class="min-h-9 resize-none"
        required
      />
      <Button type="submit" size="icon" variant="ghost">
        <Send class="size-4" />
      </Button>
    </div>
  </form>
</template>
