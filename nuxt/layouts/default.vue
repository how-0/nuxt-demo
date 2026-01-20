<script setup lang="ts"></script>

<template>
  <div class = "layout-container">
    <div class = "actions">
    <LogoutButton />
    </div>
    <slot />
  </div>
</template>

<style scoped>
.layout-container {
  padding: 20px;
}

.actions {
  display: flex;
  justify-content: flex-end; 
  margin-bottom: 20px; 
}
</style>