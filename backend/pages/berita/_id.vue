<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="tags" :style="{ marginRight: '10px' }" />Edit Produk atau
        Jasa
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
          size="large"
          :style="{ paddingLeft: '25px', paddingRight: '25px' }"
          @click="onUpdate('draft')"
        >
          <a-icon type="save"></a-icon>
          <span>Simpan</span>
        </a-button>
        <a-button
          type="primary"
          size="large"
          :style="{ paddingLeft: '25px', paddingRight: '25px' }"
          @click="onUpdate('publish')"
        >
          <a-icon type="file-done"></a-icon>
          <span>Simpan dan Tampilkan</span>
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
        Halaman ini dipergunakan untuk mengupdate data produk dan jasa yang
        terdapat pada sistem.
        <br />Untuk menyimpan data produk atau jasa baru silahakan tekan tombol
        <strong>Simpan</strong>, sedangkan untuk membatalkan tekan tombol
        <strong>Batalkan</strong>
      </div>
    </div>
    <berita-form ref="productForm" @saved="saved" :id="id" />
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  components: {
    beritaForm: () => import("~/components/berita/beritaForm")
  },
  head() {
    return {
      title: "Ubah produk atau jasa",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Ubah produk atau jasa"
        }
      ]
    };
  },
  data() {
    return {
      id: ""
    };
  },
  watch: {
    "$route.params.id": {
      deep: true,
      immediate: true,
      handler(id) {
        this.id = id;
      }
    }
  },
  methods: {
    onUpdate(type) {
      this.$refs.productForm.updatePost(type);
    },
    cancel() {
      this.$router.push({ name: "berita" });
    },
    saved(data) {
      this.$notification.success({
        message: "Informasi",
        description: "Data berhasil disimpan"
      });
      this.$router.push({ name: "berita" });
    }
  }
};
</script>
