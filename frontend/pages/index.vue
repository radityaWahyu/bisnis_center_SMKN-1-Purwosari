<template>
  <section>
    <hero />
    <middle-gallery :loading="loading" :row="product" />
    <bottom-gallery :loading="loading" :row="news" />
  </section>
</template>

<script>
export default {
  name: "beranda",
  async fetch() {
    try {
      this.loading = true;
      const [news, product] = await Promise.all([
        this.$store.dispatch("news/getNews", "limit=3"),
        this.$store.dispatch("product/getProduct", "best=true&random=true"),
      ]);
      this.product = product.data;
      this.news = news.data;
    } catch (error) {
      console.log(error);
    }
    this.loading = false;
  },
  head() {
    return {
      title: "Pusat Bisnis SMKN 1 Purwosari",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Selamat datang di pusat bisnis SMK Negeri 1 Purwosari",
        },
      ],
    };
  },
  data() {
    return {
      loading: false,
      product: [],
      news: [],
    };
  },
  components: {
    hero: () => import("~/components/beranda/hero"),
    middleGallery: () => import("~/components/beranda/middleGallery"),
    bottomGallery: () => import("~/components/beranda/bottomGallery"),
  },
};
</script>
