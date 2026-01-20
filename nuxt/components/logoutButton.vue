<template>
<a-button type="primary" @click="handleLogout">
    <template #icon>
        <icon-delete />
    </template>
    <template #default>Logout</template>
</a-button>
</template>

<script setup>
import { navigateTo } from '#app'
const { logout } = useSanctumAuth()

const handleLogout = async () => {
  try {
    await logout()
    navigateTo('/login') 
  } catch (error) {
    console.error('Logout failed', error)
  }
}
</script>