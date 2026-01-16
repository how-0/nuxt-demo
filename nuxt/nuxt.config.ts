// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: ['arco-design-nuxt-module', 'nuxt-auth-sanctum'],
  ssr: false,
  arco: {
    importPrefix: 'A',
    hookPrefix: 'Arco',
    locales: ['getLocale'],
    localePrefix: 'Arco',
  },
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  sanctum: {
    baseUrl: 'http://127.0.0.1:8000', // Laravel API
    mode: 'cookie',
    redirectIfAuthenticated: false,
    redirectIfUnauthenticated: false,
    endpoints: {
        csrf: '/sanctum/csrf-cookie',
        login: 'api/login',
        logout: 'api/logout',
        user: '/api/user',
    },
    csrf: {
        cookie: 'XSRF-TOKEN',
        header: 'X-XSRF-TOKEN',
    },
    client: {
        retry: false,
        initialRequest: true,
    },
    redirect: {
        keepRequestedRoute: false,
        onLogin: '/',
        onLogout: '/',
        onAuthOnly: '/login',
        onGuestOnly: '/',
    },
    globalMiddleware: {
        enabled: false,
        allow404WithoutAuth: true,
    },
    logLevel: 3,
    appendPlugin: false,
  },
  runtimeConfig: {
    public: {
      //apiUrl: 'https://quiz.mytkkf.com.my/api',
      apiUrl: 'http://localhost:8000/api',
    },
  },
})