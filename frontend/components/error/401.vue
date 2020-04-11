<template>
  <div class="content container"></div>
</template>
<script>
export default {
  props: {
    error: {
      type: Object,
      default: () => {},
    },
  },
  methods: {
    goDashboard() {
      this.$router.push({ name: "dashboard" });
    },
  },
};
</script>
