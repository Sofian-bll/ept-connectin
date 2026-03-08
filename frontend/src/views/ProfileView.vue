<script setup>
  import { onMounted, ref, computed } from 'vue'
  import { useUser } from '@/composables/useUser.js'
  import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
  import { Button } from '@/components/ui/button'
  import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
  } from '@/components/ui/card'
  import { Field, FieldGroup, FieldLabel } from '@/components/ui/field'
  import { Input } from '@/components/ui/input'
  import { Textarea } from '@/components/ui/textarea'
  import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
  } from '@/components/ui/dialog'
  import { Skeleton } from '@/components/ui/skeleton'
  import { Camera } from 'lucide-vue-next'

  const { me, loading, error, fetchMe, updateProfile, updatePassword, deleteAccount } = useUser()

  const avatarFile = ref(null)
  const avatarPreview = ref(null)
  const avatarInput = ref(null)

  const avatarSrc = computed(() => avatarPreview.value ?? me.value?.avatar ?? null)

  const first_name = ref('')
  const last_name = ref('')
  const email = ref('')
  const bio = ref('')
  const birthday = ref('')
  const birthplace_city = ref('')
  const birthplace_country = ref('')

  const current_password = ref('')
  const password = ref('')
  const password_confirmation = ref('')
  const passwordSuccess = ref(false)

  const deleteOpen = ref(false)
  const deleteStrategy = ref('anonymize')

  onMounted(async () => {
    await fetchMe()
    if (me.value) {
      first_name.value = me.value.first_name ?? ''
      last_name.value = me.value.last_name ?? ''
      email.value = me.value.email ?? ''
      bio.value = me.value.bio ?? ''
      birthday.value = me.value.birthday ?? ''
      birthplace_city.value = me.value.birthplace_city ?? ''
      birthplace_country.value = me.value.birthplace_country ?? ''
    }
  })

  function handleAvatarChange(event) {
    const file = event.target.files[0]
    if (!file) return
    avatarFile.value = file
    if (avatarPreview.value) URL.revokeObjectURL(avatarPreview.value)
    avatarPreview.value = URL.createObjectURL(file)
  }

  async function handleUpdateProfile() {
    await updateProfile(
      {
        first_name: first_name.value,
        last_name: last_name.value,
        name: `${first_name.value} ${last_name.value}`,
        email: email.value,
        bio: bio.value,
        birthday: birthday.value,
        birthplace_city: birthplace_city.value,
        birthplace_country: birthplace_country.value,
      },
      avatarFile.value
    )
    avatarFile.value = null
    if (avatarInput.value) avatarInput.value.value = ''
  }

  async function handleUpdatePassword() {
    passwordSuccess.value = false
    await updatePassword(
      current_password.value,
      password.value,
      password_confirmation.value
    )
    if (!error.value) {
      current_password.value = ''
      password.value = ''
      password_confirmation.value = ''
      passwordSuccess.value = true
    }
  }

  function handleDelete() {
    deleteAccount(deleteStrategy.value)
  }
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-6 space-y-6">
    <div v-if="loading && !me" class="space-y-4">
      <Skeleton class="h-32 w-full rounded-lg" />
      <Skeleton class="h-64 w-full rounded-lg" />
    </div>

    <template v-else-if="me">
      <Card>
        <CardHeader class="flex-row items-center gap-4 space-y-0">
          <label class="relative cursor-pointer group shrink-0">
            <Avatar class="size-16">
              <AvatarImage v-if="avatarSrc" :src="avatarSrc" />
              <AvatarFallback class="text-lg">
                {{ me.first_name?.charAt(0) }}{{ me.last_name?.charAt(0) }}
              </AvatarFallback>
            </Avatar>
            <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
              <Camera class="size-5 text-white" />
            </div>
            <input
              ref="avatarInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleAvatarChange"
            />
          </label>
          <div>
            <CardTitle>{{ me.name }}</CardTitle>
            <CardDescription>{{ me.email }}</CardDescription>
            <p v-if="me.bio" class="text-sm text-muted-foreground mt-1">{{ me.bio }}</p>
          </div>
        </CardHeader>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle class="text-base">Edit Profile</CardTitle>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="handleUpdateProfile">
            <FieldGroup>
              <div class="grid grid-cols-2 gap-4">
                <Field>
                  <FieldLabel>First Name</FieldLabel>
                  <Input v-model="first_name" required />
                </Field>
                <Field>
                  <FieldLabel>Last Name</FieldLabel>
                  <Input v-model="last_name" required />
                </Field>
              </div>
              <Field>
                <FieldLabel>Email</FieldLabel>
                <Input v-model="email" type="email" required />
              </Field>
              <Field>
                <FieldLabel>Bio</FieldLabel>
                <Textarea v-model="bio" rows="3" placeholder="Tell us about yourself..." />
              </Field>
              <div class="grid grid-cols-3 gap-4">
                <Field>
                  <FieldLabel>Birthday</FieldLabel>
                  <Input v-model="birthday" type="date" />
                </Field>
                <Field>
                  <FieldLabel>City</FieldLabel>
                  <Input v-model="birthplace_city" placeholder="Paris" />
                </Field>
                <Field>
                  <FieldLabel>Country</FieldLabel>
                  <Input v-model="birthplace_country" placeholder="France" />
                </Field>
              </div>
              <p v-if="error" class="text-sm text-destructive">{{ error }}</p>
              <div class="flex justify-end">
                <Button type="submit" :disabled="loading">
                  {{ loading ? 'Saving...' : 'Save changes' }}
                </Button>
              </div>
            </FieldGroup>
          </form>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle class="text-base">Change Password</CardTitle>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="handleUpdatePassword">
            <FieldGroup>
              <Field>
                <FieldLabel>Current Password</FieldLabel>
                <Input v-model="current_password" type="password" required />
              </Field>
              <Field>
                <FieldLabel>New Password</FieldLabel>
                <Input v-model="password" type="password" required />
              </Field>
              <Field>
                <FieldLabel>Confirm New Password</FieldLabel>
                <Input v-model="password_confirmation" type="password" required />
              </Field>
              <p v-if="passwordSuccess" class="text-sm text-green-600">Password updated.</p>
              <div class="flex justify-end">
                <Button type="submit" :disabled="loading">
                  {{ loading ? 'Updating...' : 'Change password' }}
                </Button>
              </div>
            </FieldGroup>
          </form>
        </CardContent>
      </Card>

      <Card class="border-destructive">
        <CardHeader>
          <CardTitle class="text-base text-destructive">Danger Zone</CardTitle>
          <CardDescription>
            Once you delete your account, there is no going back.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Dialog v-model:open="deleteOpen">
            <DialogTrigger as-child>
              <Button variant="destructive">Delete my account</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogHeader>
                <DialogTitle>Delete account</DialogTitle>
                <DialogDescription>
                  This action cannot be undone. Choose what happens to your content.
                </DialogDescription>
              </DialogHeader>
              <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" v-model="deleteStrategy" value="anonymize" />
                  <div>
                    <p class="text-sm font-medium">Anonymize</p>
                    <p class="text-xs text-muted-foreground">
                      Your posts stay but your name becomes "Deleted User"
                    </p>
                  </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="radio" v-model="deleteStrategy" value="delete" />
                  <div>
                    <p class="text-sm font-medium">Delete everything</p>
                    <p class="text-xs text-muted-foreground">
                      All your posts, comments and likes will be permanently deleted
                    </p>
                  </div>
                </label>
              </div>
              <DialogFooter>
                <Button variant="outline" @click="deleteOpen = false">Cancel</Button>
                <Button variant="destructive" @click="handleDelete">Confirm deletion</Button>
              </DialogFooter>
            </DialogContent>
          </Dialog>
        </CardContent>
      </Card>
    </template>
  </div>
</template>
