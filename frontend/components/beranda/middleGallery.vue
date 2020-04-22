<template>
  <div class="middle content container">
    <div class="title">
      <h4>Produk dan Jasa Unggulan :</h4>
      <p>Berisikan daftar produk dan jasa unggulan untuk setiap jurusan.</p>
    </div>
    <!-- show message when not data present -->
    <b-message type="is-info" has-icon v-if="row.length === 0">
      <h5 :style="{ marginBottom: '0px' }">Informasi :</h5>
      <p :style="{ fontSize: '14px' }">
        Maaf, Belum terdapat <strong>PRODUK UNGGULAN</strong> yang disimpan
        kedalam sistem.
      </p>
    </b-message>
    <div class="gallery">
      <product-item
        v-for="item in row"
        :key="item.id"
        :data="item"
        :loading="loading"
      />
      <b-loading :active="loading" :is-full-page="false" />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    loading: {
      type: Boolean,
      required: true,
    },
    row: {
      typw: Array,
      required: true,
    },
  },
  components: {
    productItem: () => import("~/components/ui/productItem"),
  },
};
</script>
