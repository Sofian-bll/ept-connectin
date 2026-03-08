<script setup>
  import { useRoute } from 'vue-router'
  import SideBar from '@/components/SideBar.vue'

  const route = useRoute()
  const publicRoutes = ['/login', '/register']
</script>

<template>
  <div
    v-if="!publicRoutes.includes(route.path)"
    class="flex min-h-screen mx-auto max-w-6xl"
  >
    <SideBar />
    <main class="flex-1 border-r min-h-screen">
      <RouterView />
    </main>
  </div>
  <RouterView v-else />
</template>
