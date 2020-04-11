<template>
  <div class="hero">
    <div class="container">
      <div class="hero-left">
        <h2>
          Pusat Bisnis<br />
          SMK Negeri 1 Purwosari
        </h2>
        <p>
          Website ini dipergunakan untuk menampilkan dan mempromosikan semua
          produk usaha mulai dari jasa sampai dengan produk jadi. Semua produk
          tersebut merupakan hasil kerjasama antara pengajar dan siswa SMK
          Negeri 1 Purwosari. Penasaran dengan kita silahkan hubungi kami.
        </p>
        <b-button size="is-large" type="is-primary" @click="kontak" rounded>
          Hubungi Kami
        </b-button>
      </div>
      <img
        src="~assets/image/hero_image.png"
        alt="hero-image"
        class="hero-right"
      />
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    kontak() {
      this.$router.push({ name: "kontak" });
    },
  },
};
</script>
