<template>
  <!-- define spin loading page -->
  <a-spin
    :indicator="indicator"
    id="spinner"
    :tip="spinner.text"
    :spinning="spinner.show"
  >
    <a-layout :style="{ height: '100vh' }">
      <!-- define header page -->
      <layout-header />
      <a-layout :style="{ marginTop: '50px' }">
        <!-- define navigation page -->
        <layout-navigation />

        <a-layout :style="{ overflowX: 'visible', display: 'inline-block' }">
          <!-- define breadcrumb layout -->
          <layout-breadcrumb />
          <!-- define content layout -->
          <a-layout-content
            :style="{
              padding: '15px 24px 24px 24px',
              backgroundColor: '#f2f4f7',
              borderTop: 'solid 1px #EDEFF2',
              minHeight: '100vh'
            }"
          >
            <!-- define page changer in nuxtjs -->
            <nuxt />
          </a-layout-content>
        </a-layout>
      </a-layout>
    </a-layout>
  </a-spin>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  middleware: "isAuth",
  data() {
    return {
      indicator: (
        <a-icon type="loading" style="font-size: 28px; color: #fff" spin />
      )
    };
  },
  components: {
    layoutHeader: () => import("~/components/layout/header"),
    layoutNavigation: () => import("~/components/layout/navigation"),
    layoutBreadcrumb: () => import("~/components/layout/breadcrumb")
  },
  computed: {
    ...mapGetters({
      spinner: "spinner/get_spinner"
    })
  }
};
</script>
