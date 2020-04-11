export default {
  mode: 'spa',
  /*
   ** Headers of the page
   */
  head: {
    title: process.env.npm_package_name || '',
    meta: [{
        charset: 'utf-8'
      },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1'
      },
      {
        hid: 'description',
        name: 'description',
        content: process.env.npm_package_description || ''
      }
    ],
    link: [{
        rel: 'icon',
        type: 'image/x-icon',
        href: '/favicon.ico'
      },
      {
        rel: 'stylesheet',
        type: 'text/css',
        href: 'https://fonts.googleapis.com/css?family=Roboto&display=swap'
      },
    ]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: {
    color: '#fff'
  },
  /*
   ** Global CSS
   */
  css: [
    //'ant-design-vue/dist/antd.css'
    '~/assets/stylesheet/main.css',
    {
      src: 'ant-design-vue/dist/antd.less',
      lang: 'less'
    }
  ],
  /*
   ** Plugins to load before mounting the App
   */
  plugins: [
    '@/plugins/antd-ui',
    '~/plugins/axios',
    '~/plugins/helper',
    '~/plugins/ckeditor',
    '~/plugins/apexChart'
  ],
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    // Doc: https://github.com/nuxt-community/eslint-module
    '@nuxtjs/eslint-module'
  ],
  /*
   ** Nuxt.js modules
   */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
    // Doc: https://github.com/nuxt-community/dotenv-module
    '@nuxtjs/dotenv',
    "nuxt-imagemin"
  ],
  /*
   ** Axios module configuration
   ** See https://axios.nuxtjs.org/options
   */
  axios: {
    baseURL:'http://localhost/bisnis_center/server/public/api/admin/',
    withCredentials: true,
    headers: {
      common: {
        'Cache-Control': 'no-cache'
      }
    }
  },
  /*
   ** Router configuration
   ** See https://axios.nuxtjs.org/options
   */
  router: {
    middleware: 'refreshToken',
  },
  messages: {
    loading: 'Loading...',
    error_404: 'Maaf, halaman yang anda cari tidak ditemukan',
    server_error: 'Maaf, terjadi kesalahan dalam server kami. Silahkan hubungi Administrator',
  },
  /*
   ** Build configuration
   */
  build: {
    /*
     ** You can extend webpack config here
     */
    extend(config, ctx) {},
    transpile: [/^element-ui/],
    loaders: {
      less: {
        javascriptEnabled: true,
        modifyVars: {
          // You can here change your Ant vars
          'primary-color': '#7468a6',
          'border-radius-base': '3px',
          'btn-font-weight': '600',
          'card-radius': '4px',
          'text-color': '#2F495E',
          'menu-dark-bg': '#271232',
        }
      },
    }
  }
}
