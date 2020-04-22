<template>
  <section :style="{ marginBottom: '50px' }">
    <div class="header">
      <div class="container">
        <h3 class="title">BERITA PUSAT BISNIS</h3>
      </div>
    </div>
    <div class="content container">
      <div class="title">
        <p>
          Berisikan berita yang terbaru yang di produksi oleh setiap jurusan
          yang terdapat pada SMKN 1 Purwosari.
        </p>
      </div>
      <div class="gallery">
        <news-card v-for="item in news" :key="item.id" :data="item" />
        <!-- show loader when fetch data -->
        <b-loading :is-full-page="false" :active="loading"></b-loading>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  async fetch() {
    try {
      this.loading = true;
      const { data, meta } = await this.$store.dispatch(
        "news/getNews",
        "paginate=6"
      );
      this.news = data;
      this.meta = meta;
    } catch (error) {
      console.log(error);
    }
    this.loading = false;
  },
  head() {
    return {
      title: "Berita Pusat Bisnis",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Daftar berita pusat bisnis SMKN 1 Purwosari",
        },
      ],
    };
  },
  data() {
    return {
      loading: false,
      news: [],
      meta: [],
    };
  },
  components: {
    newsCard: () => import("~/components/ui/newsCard"),
  },
};
</script>
