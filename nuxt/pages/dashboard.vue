<template>
  <br>
  <a-button class = "action_button" type="primary" @click="goToCreate">
    <icon-plus /> Create Tickets
  </a-button>  
  <ticketTable />
</template>

<script setup lang="ts">
const goToCreate = () => {
  navigateTo('/ticket/')
}

definePageMeta({
  middleware: 'guest',
})
</script>

<style scoped>
.action_button {
  margin-left: 20px;
}
</style>
