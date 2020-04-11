<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="user" :style="{ marginRight: '10px' }" />Edit Profil User
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
          <a-icon type="user"></a-icon>
          <span>Update Profil</span>
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
    <user-form ref="userForm" @saved="saved" :id="id" type="profil" />
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  components: {
    userForm: () => import("~/components/user/userForm")
  },
  head() {
    return {
      title: "Update Profil",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Update profil User"
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
      this.$refs.userForm.updateProfil();
    },
    cancel() {
      this.$router.push({ name: "dashboard" });
    },
    saved(data) {
      this.$notification.success({
        message: "Informasi",
        description: "Data berhasil disimpan"
      });
      this.$store.dispatch("auth/getUser");
    }
  }
};
</script>
