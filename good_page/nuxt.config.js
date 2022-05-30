export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'Good page',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'My cool web for watching the girl' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', type: 'text/css', href: '/sematic/semantic.min.css'}
    ],
    script: [
      { src: 'https://code.jquery.com/jquery-3.1.1.min.js',
        integrity: 'sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=',
        crossorigin: "anonymous"
      },
      {
        src: "/sematic/semantic.min.js"
      }
    ]
  },

  // Customize loading bar
  loading: {
    color: '#fa923f',
    height: '10px',
    duration: 5000
  },
  loadingIndicator: {
    name: 'circle',
  },

  env: {
    default_text: 'WELCOME HOANG SON RETURN YOUR PAGE !'
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
  ],

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
