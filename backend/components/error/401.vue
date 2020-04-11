<template>
  <div>
    <a-alert type="warning" banner showIcon class="alert-401">
      <template slot="message">Peringatan :</template>
      <template slot="description">
        Maaf, Anda tidak diijinkan untuk mengakses halaman ini.<br />
        Silahkan menghubungi <strong>Administrator</strong> apabila terdapat
        kesalahan user.<br />
        <a-button type="primary" size="large" @click="goDashboard">
          <a-icon type="home" />
          <span>Kembali ke Beranda</span>
        </a-button>
      </template>
    </a-alert>
  </div>
</template>
<script>
export default {
  props: {
    error: {
      type: Object,
      default: () => {}
    }
  },
  methods: {
    goDashboard() {
      this.$router.push({ name: "dashboard" });
    }
  }
};
</script>
