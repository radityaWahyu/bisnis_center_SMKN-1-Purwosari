<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="user" :style="{ marginRight: '10px' }" />Edit User
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
          @click="onUpdate"
        >
          <a-icon type="file-done"></a-icon>
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
        Halaman ini dipergunakan untuk mengupdate data user yang terdapat pada
        sistem.
        <br />Untuk menyimpan data produk atau jasa baru silahakan tekan tombol
        <strong>Simpan</strong>, sedangkan untuk membatalkan tekan tombol
        <strong>Batalkan</strong>
      </div>
    </div>
    <user-form ref="productForm" @saved="saved" :id="id" />
  </div>
</template>
<script>
export default {
  middleware: "isAdmin",
  components: {
    userForm: () => import("~/components/user/userForm")
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
    onUpdate() {
      this.$refs.productForm.updateUser();
    },
    cancel() {
      this.$router.push({ name: "user" });
    },
    saved(data) {
      this.$notification.success({
        message: "Informasi",
        description: "Data berhasil disimpan"
      });
      this.$router.push({ name: "user" });
    }
  }
};
</script>
