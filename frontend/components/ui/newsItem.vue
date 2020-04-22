<template>
  <div class="news-item">
    <img
      :src="
        data.image != 0
          ? getImage('thumbnail/post/' + data.image)
          : getImage(null)
      "
      :alt="data.slug"
    />
    <div class="title">
      <nuxt-link :to="{ name: 'berita-slug', params: { slug: data.slug } }">
        {{ data.title }}
      </nuxt-link>
      <p>{{ data.departement_name }}</p>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  methods: {
    readNews(slug) {
      this.$router.push({ name: "berita-slug", params: { slug } });
    },
  },
};
</script>
