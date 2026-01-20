import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as null | Record<string, any>,
    loading: false,
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async fetchUser() {
      this.loading = true

      try {
        const user = await $fetch('/api/user', {
          credentials: 'include',
        })

        this.user = user
      } catch (error) {
        this.user = null
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        await $fetch('/api/logout', {
          method: 'POST',
          credentials: 'include',
        })
      } finally {
        this.user = null
      }
    },
  },
})
