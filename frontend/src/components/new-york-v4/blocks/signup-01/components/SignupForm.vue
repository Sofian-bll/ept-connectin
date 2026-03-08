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
      <CardTitle>Créer un compte</CardTitle>
      <CardDescription>
        Renseignez vos informations pour créer votre compte
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form @submit.prevent="handleSubmit">
        <FieldGroup>
          <Field>
            <FieldLabel for="first_name">Prénom</FieldLabel>
            <Input
              v-model="first_name"
              id="first_name"
              type="text"
              placeholder="Jean"
              required
            />
          </Field>
          <Field>
            <FieldLabel for="last_name">Nom</FieldLabel>
            <Input
              v-model="last_name"
              id="last_name"
              type="text"
              placeholder="Dupont"
              required
            />
          </Field>
          <Field>
            <FieldLabel for="email">Email</FieldLabel>
            <Input
              v-model="email"
              id="email"
              type="email"
              placeholder="m@exemple.com"
              required
            />
            <FieldDescription>
              Nous utiliserons cet email pour vous contacter. Votre email ne sera pas partagé.
            </FieldDescription>
          </Field>
          <Field>
            <FieldLabel for="password">Mot de passe</FieldLabel>
            <Input v-model="password" id="password" type="password" required />
            <FieldDescription>Au moins 8 caractères.</FieldDescription>
          </Field>
          <Field>
            <FieldLabel for="confirm-password">Confirmer le mot de passe</FieldLabel>
            <Input
              v-model="password_confirmation"
              id="confirm-password"
              type="password"
              required
            />
            <FieldDescription>Veuillez confirmer votre mot de passe.</FieldDescription>
          </Field>
          <Field>
            <p v-if="error" class="text-sm text-destructive">{{ error }}</p>
            <Button type="submit" :disabled="loading">
              {{ loading ? 'Création...' : 'Créer un compte' }}
            </Button>
            <FieldDescription class="px-6 text-center">
              Déjà un compte ?
              <a @click="router.push('/login')" class="cursor-pointer underline-offset-4 hover:underline">Se connecter</a>
            </FieldDescription>
          </Field>
        </FieldGroup>
      </form>
    </CardContent>
  </Card>
</template>
