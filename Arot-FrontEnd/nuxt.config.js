export default {
  // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
  ssr: false,
  target: 'static',

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: 'Arotdar',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: {
    color: '#00cae3b8'
  },
  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [
    '~/assets/css/style.css'
  ],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    { src: '~/plugins/base.js', ssr: false },
    { src: '~/plugins/vuetify.js', ssr: false },
    { src: '~/plugins/i18n.js' },
    { src: "~/plugins/apexcharts.js", mode: "client", ssr: false }
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    '@nuxtjs/pwa',
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/pwa',
    '@nuxtjs/auth',
  ],

  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    baseURL: 'http://localhost:8000/api',
    // baseURL: 'https://arotbackend.orionisbd.com/api',
    credentials: true
  },
  //auth strategies
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'auth/login',
            method: 'post',
            propertyName: false
          },
          logout: {
            url: 'auth/logout',
            method: 'post'
          },
          user: false,
          //user: { url: 'auth/userinfo', method: 'get', propertyName: false, autoFetch: false },
        },
        // tokenRequired: false,
        // tokenType: false
      }
    },
    localStorage: false,
    redirect: {
      login: '/',
      logout: '/',
      callback: '/',
      home: '/dashboard'
    }
  },
  /* add pwa message */
  pwa: {
    meta: {
      title: 'Arotdar',
      author: '',
    },
    manifest: {
      name: 'Arotdar is arot management application',
      short_name: 'Arotdar is arot management application',
      lang: 'en',
    },
    workbox: {
      preCaching: [
        {
          url: '/dashboard'
        }
      ],
      runtimeCaching: [
        {
          urlPattern: new RegExp("(.*)"),
          handler: "cacheFirst"
        }
      ]
    }
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {

  }
}
