<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="tags" :style="{ marginRight: '10px' }" />Tambah Produk
        atau Jasa
      </h2>
      <div>
        <a-button
          type="link"
          :style="{ paddingLeft: '25px', paddingRight: '25px' }"
          size="large"
          @click="cancel"
        >
          <a-icon type="close-circle"></a-icon>
          <span>Batalkan</span>
        </a-button>
        <a-button
          type="primary"
          size="large"
          :style="{ paddingLeft: '25px', paddingRight: '25px' }"
          @click="onSave"
        >
          <a-icon type="check"></a-icon>
          <span>Simpan</span>
        </a-button>
      </div>
    </div>
    <div :style="{ display: 'flex', marginBottom: '20px' }">
      <a-icon
        type="info-circle"
        :style="{ fontSize: '40px', margin: '10px' }"
        theme="twoTone"
        two-tone-color="#4163E2"
      />
      <div :style="{ verticalAlign: 'top', margin: '10px' }">
        Halaman ini dipergunakan untuk membuat produk dan jasa yang akan
        disimpan pada sistem.
        <br />Untuk menyimpan data produk atau jasa baru silahakan tekan tombol
        <strong>Simpan</strong>, sedangkan untuk membatalkan tekan tombol
        <strong>Batalkan</strong>
      </div>
    </div>
    <produk-form ref="productForm" @saved="saved" />
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  head() {
    return {
      title: "Tambah produk atau jasa",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Tambah produk atau jasa"
        }
      ]
    };
  },
  components: {
    produkForm: () => import("~/components/produk/produkForm")
  },
  methods: {
    onSave(e) {
      this.$refs.productForm.saveProduct(e);
    },
    cancel() {
      this.$router.push({ name: "produk" });
    },
    saved(data) {
      this.$notification.success({
        message: "Informasi",
        description: "Data berhasil disimpan"
      });
      this.$router.push({ name: "produk" });
    }
  }
};
</script>
