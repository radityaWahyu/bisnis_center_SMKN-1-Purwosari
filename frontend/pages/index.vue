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
  async asyncData({ store }) {
    try {
      const [news, product] = await Promise.all([
        store.dispatch("news/getNews", "limit=3"),
        store.dispatch("product/getProduct", "best=true&random=true"),
      ]);
      return {
        product: product.data,
        news: news.data,
        loading: false,
      };
    } catch (error) {
      console.log(error);
    }
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
