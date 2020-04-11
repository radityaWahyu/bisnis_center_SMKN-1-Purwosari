<template>
  <div class="bottom-content">
    <div class="container">
      <div class="title">
        <h4>Berita Terbaru :</h4>
        <p>
          Berisikan daftar berita terbaru yang terdapat dalam Pusat Bisnis SMKN
          1 Purwosari.
        </p>
      </div>
      <!-- show message when not data present -->
      <b-message type="is-info" has-icon v-if="row.length === 0">
        <h5 :style="{ marginBottom: '0px' }">Informasi :</h5>
        <p :style="{ fontSize: '14px' }">
          Maaf, Belum terdapat <strong>Berita</strong> yang disimpan kedalam
          sistem.
        </p>
      </b-message>
      <div class="gallery" v-else>
        <news-item :data="item" v-for="item in row" :key="item.id" />
      </div>
      <b-loading :active="loading" :is-full-page="false" />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    row: {
      type: Array,
      required: true,
    },
    loading: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    newsItem: () => import("~/components/ui/newsItem"),
  },
};
</script>
