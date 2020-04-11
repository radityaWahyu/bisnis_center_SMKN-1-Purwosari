<template lang="html">
  <div v-if="loading" class="loading-page">
    <img src="~assets/image/logo.png" alt="PusatBisnis" />
    <p>Memuat...</p>
  </div>
</template>

<script>
export default {
  data: () => ({
    loading: false,
  }),
  methods: {
    start() {
      this.loading = true;
    },
    finish() {
      this.loading = false;
    },
  },
};
</script>
