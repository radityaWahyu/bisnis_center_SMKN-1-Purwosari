<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="tags" :style="{ marginRight: '10px' }" />Produk dan Jasa
      </h2>
      <div>
        <span v-if="selectedRow.length > 0">
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
            type="default"
            :style="{
              paddingLeft: '25px',
              paddingRight: '25px',
              backgroundColor: '#C62828',
              color: '#FFF',
              borderColor: '#E53935'
            }"
            size="large"
            @click="onDelete"
          >
            <a-icon type="delete"></a-icon>
            <span>Hapus</span>
          </a-button>
        </span>
        <span v-else>
          <a-button
            type="primary"
            size="large"
            :style="{ paddingLeft: '25px', paddingRight: '25px' }"
            @click="add"
          >
            <a-icon type="plus"></a-icon>
            <span>Tambah</span>
          </a-button>
        </span>
      </div>
    </div>
    <div :style="{ display: 'flex' }">
      <a-icon
        type="info-circle"
        :style="{ fontSize: '40px', margin: '10px' }"
        theme="twoTone"
        two-tone-color="#4163E2"
      />
      <div :style="{ verticalAlign: 'top', margin: '10px' }">
        Halaman ini dipergunakan untuk memanajemen produk dan jasa setiap
        kompetensi yang terdapat pada SMKN 1 Purwosari.
        <br />Untuk menambah produk atau jasa baru silahakan tekan tombol
        <strong>Tambah</strong>, sedangkan untuk menhapus data tekan tombol
        <strong>Hapus</strong>
      </div>
    </div>
    <produk-table ref="dataTable" @selectedRow="selectedRowTable" />
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  data() {
    return {
      selectedRow: []
    };
  },
  head() {
    return {
      title: "Produk dan Jasa",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Manajemen data produk atau jasa"
        }
      ]
    };
  },
  components: {
    produkTable: () => import("~/components/produk/produkTable")
  },
  methods: {
    selectedRowTable(data) {
      this.selectedRow = data;
    },
    cancel() {
      this.$refs.dataTable.onCancel();
    },
    add() {
      this.$router.push({ name: "produk-create" });
    },
    onSave() {
      this.$refs.dataTable.fetchData();
      this.$notification.success({
        message: "Informasi",
        description: "Data berhasil disimpan"
      });
    },
    onDelete() {
      const _this = this;

      this.$confirm({
        title: "Konfirmasi",
        content: `Apakah anda ingin menghapus ${this.selectedRow.length} data ?`,
        okText: "Hapus Data",
        cancelText: "Batalkan",
        onOk() {
          return new Promise((resolve, reject) => {
            _this.$axios
              .$post(`item/delete`, { id: _this.selectedRow })
              .then(response => {
                setTimeout(resolve(response), 2000);
              })
              .catch(error => {
                reject(error.response);
              });
          })
            .then(() => {
              _this.$notification.success({
                message: "Informasi",
                description: "Data Berhasil dihapus dari sistem."
              });
              _this.selectedRow = [];
              _this.$refs.dataTable.fetchData();
            })
            .catch(error => {
              console.log(error);
            });
        },
        onCancel() {}
      });
    }
  }
};
</script>
