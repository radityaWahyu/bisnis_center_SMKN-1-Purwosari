<template>
  <a-modal
    v-model="visible"
    :closable="false"
    :footer="null"
    :bodyStyle="{
      padding: '0px',
      backgroundColor: '#F2F4F7',
      borderRadius: '0px 0px 3px 3px',
      minHeight: '400px'
    }"
    :keyboard="false"
    :maskClosable="false"
    :afterClose="onClose"
    width="600px"
  >
    <template slot="title">
      <a-icon
        type="file-image"
        :style="{ fontSize: '20px', marginRight: '5px' }"
      ></a-icon>
      <span :style="{ fontSize: '20px', fontWeight: '600' }">Gambar</span>
      <div :style="{ float: 'right' }">
        <a-button type="primary" @click="onDelete">
          <a-icon type="delete" :style="{ marginRight: '5px' }"></a-icon>
          Hapus
        </a-button>
        <a-button
          type="default"
          :style="{ marginLeft: '5px' }"
          @click="onClose"
        >
          <a-icon type="close-circle" :style="{ marginRight: '5px' }"></a-icon>
          Tutup
        </a-button>
      </div>
    </template>
    <div class="image-spin" v-if="loading">
      <a-spin />
    </div>
    <div class="image-box" v-else>
      <div class="caption">
        {{ row.caption }}
      </div>
      <img
        :alt="row.caption"
        :src="
          row.image != 0
            ? getImage('image/gallery/' + row.image)
            : getImage(null)
        "
        width="100%"
        height="100%"
      />
    </div>
  </a-modal>
</template>
<script>
export default {
  data() {
    return {
      visible: false,
      loading: false,
      row: []
    };
  },
  methods: {
    async onShow(id) {
      this.visible = true;
      this.loading = true;
      const { data } = await this.$store.dispatch("gallery/showGallery", id);
      this.row = data;
      this.loading = false;
    },
    onClose() {
      this.visible = false;
    },
    async onDelete() {
      try {
        this.loading = true;

        await this.$store.dispatch("gallery/deleteGallery", {
          id: this.row.id
        });
        this.onClose();
        this.$emit("deleted", true);
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    }
  }
};
</script>
