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
    <h3>{{ data.title }}</h3>
    <p>
      {{ data.content }}
    </p>
    <b-button type="is-primary" @click="readNews(data.slug)" expanded
      >Selengkapnya</b-button
    >
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
