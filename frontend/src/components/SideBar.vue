<script setup>
  import { useAuth } from '@/composables/useAuth.js'
  import { useUser } from '@/composables/useUser.js'
  import { onMounted } from 'vue'
  import { useRouter, useRoute } from 'vue-router'
  import { Button } from '@/components/ui/button'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu'
  import { Home, User, Settings, LogOut, MoreHorizontal } from 'lucide-vue-next'

  const { logout } = useAuth()
  const { me, fetchMe } = useUser()
  const router = useRouter()
  const route = useRoute()

  onMounted(() => {
    fetchMe()
  })
</script>

<template>
  <aside class="sticky top-0 flex h-screen w-64 flex-col justify-between border-r px-3 py-4">
    <div class="space-y-1">
      <div class="px-3 py-4">
        <span class="text-xl font-bold">Connect'IN</span>
      </div>

      <Button
        variant="ghost"
        class="w-full justify-start gap-3 text-base h-12"
        :class="route.path === '/feed' ? 'font-bold' : ''"
        @click="router.push('/feed')"
      >
        <Home class="size-5" />
        Home
      </Button>

      <Button
        variant="ghost"
        class="w-full justify-start gap-3 text-base h-12"
        :class="route.path === `/users/${me?.id}` ? 'font-bold' : ''"
        @click="router.push(`/users/${me?.id}`)"
      >
        <User class="size-5" />
        Profile
      </Button>
    </div>

    <div class="border-t pt-3">
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <button
            class="flex w-full items-center gap-3 rounded-full p-3 hover:bg-accent transition-colors"
          >
            <Avatar class="size-9">
              <AvatarImage v-if="me?.avatar" :src="me.avatar" />
              <AvatarFallback>
                {{ me?.first_name?.charAt(0) }}{{ me?.last_name?.charAt(0) }}
              </AvatarFallback>
            </Avatar>
            <div class="flex-1 text-left">
              <p class="text-sm font-medium leading-none">{{ me?.name }}</p>
              <p class="text-xs text-muted-foreground">{{ me?.email }}</p>
            </div>
            <MoreHorizontal class="size-4 text-muted-foreground" />
          </button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start" side="top" class="w-56">
          <DropdownMenuItem @click="router.push('/profile')">
            <Settings class="size-4" />
            Paramètres
          </DropdownMenuItem>
          <DropdownMenuSeparator />
          <DropdownMenuItem class="text-destructive" @click="logout()">
            <LogOut class="size-4" />
            Log out
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  </aside>
</template>
