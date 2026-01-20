<script setup lang="ts">
definePageMeta({
  middleware: 'guest',
})
</script>

<template>
  <h1>Welcome to the homepage</h1>
  <FillableFormLogin />
</template>