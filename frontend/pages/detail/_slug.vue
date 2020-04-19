<template>
  <section>
    <div class="header">
      <div class="container"></div>
    </div>
    <div class="content container">
      <div class="detail">
        <img
          v-if="loading"
          src="~/assets/image/no_image.png"
          alt="no_image"
          class="no-cover"
        />
        <img
          v-else
          :src="
            row.image != 0
              ? getImage('image/item/' + row.image)
              : getImage(null)
          "
          :alt="row.slug"
        />
        <div class="description">
          <PuSkeleton v-if="loading" />
          <h3 v-else>{{ row.title }}</h3>
          <PuSkeleton v-if="loading" width="50%" height="8px" />
          <h4 v-else>Jurusan {{ row.departement_name }}</h4>
          <div
            v-if="loading"
            :style="{ marginTop: '40px', marginBottom: '40px' }"
          >
            <PuSkeleton :count="8" />
          </div>
          <div class="content-one" v-else v-html="row.description"></div>
          <div class="info">
            <img src="~/assets/image/avatar.png" />
            <div class="kontak" v-if="loading">
              <p :style="{ fontSize: '13px' }">Kontak :</p>
              <PuSkeleton :count="2" height="8px" width="70%" />
            </div>
            <div class="kontak" v-else>
              <p :style="{ fontSize: '13px' }">Kontak :</p>
              <p v-if="row.contact !== 'null'">{{ row.contact }}</p>
              <p v-if="row.contact !== 'null'">{{ row.contact_number }}</p>
              <p v-else>-</p>
            </div>
          </div>
        </div>
      </div>
      <b-tabs type="is-boxed" :style="{ fontWeight: '500' }" :animated="false">
        <b-tab-item label="Ulasan" icon="message">
          <review-product :id="row.id" />
        </b-tab-item>
        <b-tab-item label="Galeri Gambar" icon="folder-image">
          <image-gallery :id="row.id" />
        </b-tab-item>
      </b-tabs>
    </div>
  </section>
</template>
<script>
export default {
  head() {
    return {
      title: this.row.title,
      meta: [
        {
          hid: "description",
          name: "description",
          content: this.row.title,
        },
      ],
    };
  },
  mounted() {
    this.getData(this.$route.params.slug);
  },
  data() {
    return {
      slug: "",
      row: [],
      review: [],
      loading: false,
    };
  },
  components: {
    reviewProduct: () => import("~/components/product/review"),
    imageGallery: () => import("~/components/product/galleryProduct"),
  },
  methods: {
    async getData(id) {
      try {
        this.loading = true;
        const product = await this.$store.dispatch("product/showProduct", id);
        this.row = product.data;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
  },
};
</script>
