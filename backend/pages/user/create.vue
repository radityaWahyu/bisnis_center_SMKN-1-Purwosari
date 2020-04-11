<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="user-add" :style="{ marginRight: '10px' }" />Tambah User
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
          @click="onSave('draft')"
        >
          <a-icon type="save"></a-icon>
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
        Halaman ini dipergunakan untuk membuat user baru yang akan disimpan pada
        sistem.
        <br />Untuk menyimpan data berita baru silahakan tekan tombol
        <strong>Simpan</strong>, sedangkan untuk membatalkan tekan tombol
        <strong>Batalkan</strong>
      </div>
    </div>
    <user-form ref="userForm" @saved="saved" />
  </div>
</template>
<script>
export default {
  middleware: "isAdmin",
  head() {
    return {
      title: "Tambah data user",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Tambah data user"
        }
      ]
    };
  },
  components: {
    userForm: () => import("~/components/user/userForm")
  },
  methods: {
    onSave() {
      this.$refs.userForm.saveUser();
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
