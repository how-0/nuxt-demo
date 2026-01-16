<template>
  <a-form :model="form" :style="{width:'600px'}" @submit="onLogin">
    <a-form-item field="name" label="Username" validate-trigger="input" required>
      <a-input v-model="form.name" placeholder="please enter your username..." />
    </a-form-item>
    <a-form-item field="password" label="Password" validate-trigger="input" required>
      <a-input v-model="form.password" placeholder="please enter your password..." />
    </a-form-item>
    <a-form-item field="isLoginClicked">
      <a-space> 
        <a-button html-type="submit" type="primary">Login</a-button>
      </a-space>
      </a-form-item>
    <a-form-item>
      <a-space>
      <p>No account?</p>
      <a-button><NuxtLink to="/register" icon>Register</NuxtLink></a-button>
      </a-space>
    </a-form-item>
  </a-form>
</template>

<script setup>
import { reactive } from 'vue'

const form = reactive({
  name: '',
  password: '',
})

const { login } = useSanctumAuth()

const onLogin = async () => {
  try {
    const userCredentials = {
      name: form.name,
      password: form.password,
    }

    const response = await login(userCredentials)

    console.log('Login success:', response)

    // save token if returned
    if (response.token) {
      localStorage.setItem('token', response.token)
    }

    navigateTo('/dashboard')
  } catch (err) {
    console.error('Login failed', err?.data || err)
  }
}
</script>

<style scoped></style>
