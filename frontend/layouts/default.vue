<template>
  <div>
    <top-navigation />
    <nuxt />
    <layout-footer />
  </div>
</template>

<script>
export default {
  layoutTransition: "layout",
  middleware: "count",
  mounted() {
    this.$nextTick(() => {
      this.$nuxt.$loading.start();

      setTimeout(() => this.$nuxt.$loading.finish(), 1000);
    });
  },
  head() {
    return {
      meta: [{ hid: "robots", name: "robots", content: "index, follow" }],
    };
  },
  components: {
    topNavigation: () => import("~/components/layout/topNavigation"),
    layoutFooter: () => import("~/components/layout/footer"),
  },
};
</script>
