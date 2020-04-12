<template>
  <a-card title="GALERI GAMBAR" :bordered="false" :loading="loading">
    <a-button type="primary" slot="extra" icon="plus" @click="add" />
    <div class="gallery" v-if="row.length > 0">
      <div
        class="item"
        v-for="item in row"
        :key="item.id"
        @click="onShow(item.id)"
      >
        <img
          :alt="item.caption"
          :src="
            item.image != 0
              ? getImage('thumbnail/gallery/' + item.image)
              : getImage(null)
          "
          width="100%"
          height="100%"
        />
      </div>
    </div>
    <a-alert
      v-else
      message="Informasi"
      description="Tidak terdapat gambar terhadap produk/jasa ini"
      type="info"
      showIcon
    />
    <a-pagination
      v-if="row.length > 0"
      simple
      :defaultCurrent="paginate.current"
      :total="paginate.total"
      class="gallery-pagination"
    />
    <gallery-form ref="galleryForm" :id="id" @saved="onSuccess" />
    <image-box ref="imageBox" @deleted="onDelete" />
  </a-card>
</template>
<script>
import { mapActions } from "vuex";

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      loading: false,
      row: [],
      paginate: {
        size: "default",
        pageSize: 10,
        total: 0,
        current: 1,
        showSizeChanger: true,
        pageSizeOptions: ["10", "20", "30", "40", "50"],
        showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} data`
      }
    };
  },
  components: {
    galleryForm: () => import("~/components/produk/galleryForm"),
    imageBox: () => import("~/components/produk/imageBox")
  },
  created() {
    this.fetchData(1);
  },
  methods: {
    ...mapActions("gallery", ["getGallery"]),
    add() {
      this.$refs.galleryForm.onCreate();
    },
    onSuccess() {
      this.$notification.success({
        message: "Informasi",
        description: "Gambar berhasil disimpan ke dalam Galeri."
      });
      this.fetchData(1);
    },
    onShow(id) {
      this.$refs.imageBox.onShow(id);
    },
    onDelete() {
      this.$notification.success({
        message: "Informasi",
        description: "Gambar berhasil di hapus dari Galeri."
      });
      this.fetchData(1);
    },
    async fetchData(page) {
      this.loading = true;

      try {
        //  Get data departemen from API
        const { data, meta } = await this.getGallery(
          `item_id=${this.id}&page=${page}`
        );

        this.row = data;
        this.paginate.total = meta.total;
        this.paginate.pageSize = meta.per_page;
        this.paginate.current = meta.current_page;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    }
  }
};
</script>
