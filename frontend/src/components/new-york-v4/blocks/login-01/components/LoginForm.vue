<script setup>
  import { cn } from '@/lib/utils'
  import { ref } from 'vue'
  import { useAuth } from '@/composables/useAuth.js'
  import { Button } from '@/components/ui/button'
  import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
  } from '@/components/ui/card'
  import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
  } from '@/components/ui/field'
  import { Input } from '@/components/ui/input'
  import { useRouter } from 'vue-router'

  const { login, loading, error } = useAuth()
  const router = useRouter()

  const email = ref('')
  const password = ref('')

  function handleSubmit() {
    login(email.value, password.value)
  }

  const props = defineProps({
    class: {
      type: [Boolean, null, String, Object, Array],
      required: false,
      skipCheck: true,
    },
  })
</script>

<template>
  <div :class="cn('flex flex-col gap-6', props.class)">
    <Card>
      <CardHeader>
        <CardTitle>Login to your account</CardTitle>
        <CardDescription>
          Enter your email below to login to your account
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="handleSubmit">
          <FieldGroup>
            <Field>
              <FieldLabel for="email"> Email </FieldLabel>
              <Input
                v-model="email"
                id="email"
                type="email"
                placeholder="m@example.com"
                required
              />
            </Field>
            <Field>
              <div class="flex items-center">
                <FieldLabel for="password"> Password </FieldLabel>
                <a
                  href="#"
                  class="ml-auto inline-block text-sm underline-offset-4 hover:underline"
                >
                  Forgot your password?
                </a>
              </div>
              <Input
                v-model="password"
                id="password"
                type="password"
                required
              />
            </Field>
            <Field>
              <p v-if="error">{{ error }}</p>
              <Button type="submit" :disabled="loading">
                {{ loading ? 'Connexion...' : 'Se connecter' }}
              </Button>
              <FieldDescription class="text-center">
                Don't have an account?
                <a @click="router.push('/register')"> Sign up </a>
              </FieldDescription>
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  </div>
</template>
