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
        <a-form-item v-if="errorMessage">
      <a-alert type="error" :message="errorMessage" />
    </a-form-item>
  </a-form>
</template>

<script setup>
import { reactive, ref } from 'vue'

const errorMessage = ref('')

const form = reactive({
  name: '',
  password: '',
})

const { login } = useSanctumAuth()

console.log(login);
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
    if (err?.response?.data?.errors) {
      errorMessage.value = Object.values(err.response.data.errors)[0][0]
    } else {
      errorMessage.value = err?.response?.data?.message || 'Login failed'
    }
  }
}
</script>

<style scoped></style>
