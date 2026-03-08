<script setup>
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
</script>

<template>
  <div class="flex flex-col gap-6">
    <Card>
      <CardHeader>
        <CardTitle>Connexion</CardTitle>
        <CardDescription>
          Entrez votre email pour accéder à votre compte
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="handleSubmit">
          <FieldGroup>
            <Field>
              <FieldLabel for="email">Email</FieldLabel>
              <Input
                v-model="email"
                id="email"
                type="email"
                placeholder="m@exemple.com"
                required
              />
            </Field>
            <Field>
              <div class="flex items-center">
                <FieldLabel for="password">Mot de passe</FieldLabel>
                <a
                  href="#"
                  class="ml-auto inline-block text-sm underline-offset-4 hover:underline"
                >
                  Mot de passe oublié ?
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
              <p v-if="error" class="text-sm text-destructive">{{ error }}</p>
              <Button type="submit" :disabled="loading">
                {{ loading ? 'Connexion...' : 'Se connecter' }}
              </Button>
              <FieldDescription class="text-center">
                Pas encore de compte ?
                <a @click="router.push('/register')" class="cursor-pointer underline-offset-4 hover:underline">S'inscrire</a>
              </FieldDescription>
            </Field>
          </FieldGroup>
        </form>
      </CardContent>
    </Card>
  </div>
</template>
