<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="book" :style="{ marginRight: '10px' }" />Tambah Berita
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
          @click="onSave('draft')"
        >
          <a-icon type="save"></a-icon>
          <span>Simpan</span>
        </a-button>
        <a-button
          type="primary"
          size="large"
          :style="{ paddingLeft: '25px', paddingRight: '25px' }"
          @click="onSave('publish')"
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
        Halaman ini dipergunakan untuk membuat berita terkini yang akan disimpan
        pada sistem.
        <br />Untuk menyimpan data berita baru silahakan tekan tombol
        <strong>Simpan</strong>, sedangkan untuk membatalkan tekan tombol
        <strong>Batalkan</strong>
      </div>
    </div>
    <berita-form ref="beritaForm" @saved="saved" />
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
    beritaForm: () => import("~/components/berita/beritaForm")
  },
  methods: {
    onSave(type) {
      this.$refs.beritaForm.savePost(type);
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
