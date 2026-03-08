<script setup>
  import { onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { useUser } from '@/composables/useUser.js'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
  } from '@/components/ui/card'
  import { Skeleton } from '@/components/ui/skeleton'
  import { Separator } from '@/components/ui/separator'
  import { MapPin, Calendar, Mail } from 'lucide-vue-next'

  const route = useRoute()
  const { user, loading, fetchUser } = useUser()

  onMounted(() => {
    fetchUser(route.params.id)
  })
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-6 space-y-6">
    <div v-if="loading" class="space-y-4">
      <Skeleton class="h-32 w-full rounded-lg" />
    </div>

    <template v-else-if="user">
      <Card>
        <CardHeader class="flex-row items-center gap-4 space-y-0">
          <Avatar class="size-16">
            <AvatarImage v-if="user.avatar" :src="user.avatar" />
            <AvatarFallback class="text-lg">
              {{ user.first_name?.charAt(0) }}{{ user.last_name?.charAt(0) }}
            </AvatarFallback>
          </Avatar>
          <div>
            <CardTitle>{{ user.name }}</CardTitle>
            <p v-if="user.bio" class="text-sm text-muted-foreground mt-1">{{ user.bio }}</p>
          </div>
        </CardHeader>
        <Separator />
        <CardContent class="pt-4">
          <div class="flex flex-wrap gap-4 text-sm text-muted-foreground">
            <div v-if="user.email" class="flex items-center gap-1.5">
              <Mail class="size-4" />
              {{ user.email }}
            </div>
            <div
              v-if="user.birthplace_city || user.birthplace_country"
              class="flex items-center gap-1.5"
            >
              <MapPin class="size-4" />
              {{ [user.birthplace_city, user.birthplace_country].filter(Boolean).join(', ') }}
            </div>
            <div v-if="user.created_at" class="flex items-center gap-1.5">
              <Calendar class="size-4" />
              Joined {{ new Date(user.created_at).toLocaleDateString() }}
            </div>
          </div>
        </CardContent>
      </Card>
    </template>
  </div>
</template>
