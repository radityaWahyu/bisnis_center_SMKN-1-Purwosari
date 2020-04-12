<template>
  <div>
    <b-message
      v-if="galleryLength === 0"
      type="is-info"
      has-icon
      :style="{ marginLeft: '14px' }"
    >
      <h5 :style="{ marginBottom: '0px' }">Informasi :</h5>
      <p :style="{ fontSize: '14px' }">
        Maaf, Belum terdapat gambar pada gallery terhadap produk atau jasa
        ini.<br />
      </p>
    </b-message>
    <div class="gallery-image" v-else>
      <div class="image" v-for="item in gallery" :key="item.id">
        <img
          :src="
            item.image != 0
              ? getImage('image/gallery/' + item.image)
              : getImage(null)
          "
          :alt="item.id"
        />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      galleryLength: 0,
      gallery: [],
      meta: [],
    };
  },
  watch: {
    id: {
      immediate: true,
      handler(value) {
        if (value !== "undefined") {
          this.nextGallery(1);
        }
      },
    },
  },
  methods: {
    async nextGallery(page) {
      try {
        this.loading = true;
        const { data, meta } = await this.$store.dispatch(
          "gallery/getGallery",
          `item_id=${this.id}`
        );
        this.galleryLength = data.length;
        this.gallery = data;
        this.meta = meta;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    addReview() {
      this.$refs.reviewForm.showForm(true);
    },
    onSuccess(data) {
      this.nextGallery(1);
    },
  },
};
</script>
