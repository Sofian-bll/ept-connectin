<script setup>
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
  import { useAuth } from '@/composables/useAuth.js'
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'

  const { register, loading, error } = useAuth()
  const router = useRouter()

  const first_name = ref('')
  const last_name = ref('')
  const email = ref('')
  const password = ref('')
  const password_confirmation = ref('')

  function handleSubmit() {
    const name = `${first_name.value} ${last_name.value}`
    register(
      first_name.value,
      last_name.value,
      name,
      email.value,
      password.value,
      password_confirmation.value
    )
  }
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Create an account</CardTitle>
      <CardDescription>
        Enter your information below to create your account
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form @submit.prevent="handleSubmit">
        <FieldGroup>
          <Field>
            <FieldLabel for="first_name"> First Name </FieldLabel>
            <Input
              v-model="first_name"
              id="first_name"
              type="text"
              placeholder="John"
              required
            />
          </Field>
          <Field>
            <FieldLabel for="last_name"> Last Name </FieldLabel>
            <Input
              v-model="last_name"
              id="last_name"
              type="text"
              placeholder="John Doe"
              required
            />
          </Field>
          <Field>
            <FieldLabel for="email"> Email </FieldLabel>
            <Input
              v-model="email"
              id="email"
              type="email"
              placeholder="m@example.com"
              required
            />
            <FieldDescription>
              We'll use this to contact you. We will not share your email with
              anyone else.
            </FieldDescription>
          </Field>
          <Field>
            <FieldLabel for="password"> Password </FieldLabel>
            <Input v-model="password" id="password" type="password" required />
            <FieldDescription
              >Must be at least 8 characters long.</FieldDescription
            >
          </Field>
          <Field>
            <FieldLabel for="confirm-password"> Confirm Password </FieldLabel>
            <Input
              v-model="password_confirmation"
              id="confirm-password"
              type="password"
              required
            />
            <FieldDescription>Please confirm your password.</FieldDescription>
          </Field>
          <FieldGroup>
            <Field>
              <p v-if="error">{{ error }}</p>
              <Button type="submit" :disabled="loading">
                {{ loading ? 'Création...' : 'Créer un compte' }}
              </Button>
              <FieldDescription class="px-6 text-center">
                Already have an account?
                <a @click="router.push('/login')">Sign in</a>
              </FieldDescription>
            </Field>
          </FieldGroup>
        </FieldGroup>
      </form>
    </CardContent>
  </Card>
</template>
