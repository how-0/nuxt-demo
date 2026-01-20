export default defineNuxtRouteMiddleware((to, from) => {

  const { isAuthenticated } = useSanctumAuth()

  if (isAuthenticated.value && to.path == '/login' ){
    return navigateTo('/dashboard')
  }

  if (!isAuthenticated.value && to.path == '/dashboard' ){
    return navigateTo('/login')
  }
  
  console.log("Authenticated?" , isAuthenticated);
})