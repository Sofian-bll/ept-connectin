<script setup>
  import { ref } from 'vue'
  import { Button } from '@/components/ui/button'
  import { Input } from '@/components/ui/input'
  import { Textarea } from '@/components/ui/textarea'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Separator } from '@/components/ui/separator'
  import { ImagePlus, X } from 'lucide-vue-next'

  const props = defineProps({
    currentUser: { type: Object, required: false },
  })

  const emit = defineEmits(['submit'])

  const title = ref('')
  const content = ref('')
  const mediaFile = ref(null)
  const previewUrl = ref(null)
  const fileInput = ref(null)

  function handleFileChange(event) {
    const file = event.target.files[0]
    if (!file) return
    mediaFile.value = file
    previewUrl.value = URL.createObjectURL(file)
  }

  function handleRemoveMedia() {
    if (previewUrl.value) URL.revokeObjectURL(previewUrl.value)
    mediaFile.value = null
    previewUrl.value = null
    if (fileInput.value) fileInput.value.value = ''
  }

  function handleSubmit() {
    if (!title.value.trim() || !content.value.trim()) return
    emit('submit', title.value, content.value, mediaFile.value)
    title.value = ''
    content.value = ''
    handleRemoveMedia()
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
          <div v-if="previewUrl" class="relative">
            <img
              :src="previewUrl"
              class="w-full rounded-2xl max-h-64 object-cover border"
            />
            <button
              type="button"
              class="absolute top-2 right-2 size-7 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black/80"
              @click="handleRemoveMedia"
            >
              <X class="size-4" />
            </button>
          </div>
        </div>
      </div>
      <input
        ref="fileInput"
        type="file"
        accept="image/*"
        class="hidden"
        @change="handleFileChange"
      />
      <Separator class="my-3" />
      <div class="flex items-center justify-between">
        <Button
          type="button"
          variant="ghost"
          size="sm"
          class="text-primary rounded-full"
          @click="fileInput.click()"
        >
          <ImagePlus class="size-4" />
        </Button>
        <Button type="submit" size="sm" class="rounded-full px-5">
          Post
        </Button>
      </div>
    </form>
  </div>
</template>
