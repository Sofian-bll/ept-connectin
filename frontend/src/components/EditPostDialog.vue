<script setup>
  import { ref, watch } from 'vue'
  import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
  } from '@/components/ui/dialog'
  import { Button } from '@/components/ui/button'
  import { Input } from '@/components/ui/input'
  import { Textarea } from '@/components/ui/textarea'
  import { Field, FieldLabel } from '@/components/ui/field'

  const props = defineProps({
    open: { type: Boolean, required: true },
    post: { type: Object, required: false },
  })

  const emit = defineEmits(['update:open', 'save'])

  const title = ref('')
  const content = ref('')

  watch(
    () => props.post,
    (val) => {
      if (val) {
        title.value = val.title ?? ''
        content.value = val.content ?? ''
      }
    },
    { immediate: true }
  )

  function handleSave() {
    if (!title.value.trim() || !content.value.trim()) return
    emit('save', props.post.id, title.value, content.value)
    emit('update:open', false)
  }
</script>

<template>
  <Dialog :open="open" @update:open="emit('update:open', $event)">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Edit post</DialogTitle>
        <DialogDescription>Make changes to your post.</DialogDescription>
      </DialogHeader>
      <form @submit.prevent="handleSave" class="space-y-4">
        <Field>
          <FieldLabel>Title</FieldLabel>
          <Input v-model="title" required />
        </Field>
        <Field>
          <FieldLabel>Content</FieldLabel>
          <Textarea v-model="content" rows="4" required />
        </Field>
        <DialogFooter>
          <Button
            type="button"
            variant="outline"
            @click="emit('update:open', false)"
          >
            Cancel
          </Button>
          <Button type="submit">Save</Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
