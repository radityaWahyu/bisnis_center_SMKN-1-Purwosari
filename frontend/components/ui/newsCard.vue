<template>
  <div class="news card">
    <div class="card-image">
      <img
        :src="
          data.image != 0
            ? getImage('thumbnail/post/' + data.image)
            : getImage(null)
        "
        :alt="data.slug"
      />
    </div>
    <div class="card-content">
      <p class="title">{{ data.title }}</p>
      <p class="subtitle">{{ data.departement_name }}</p>
      <p class="content">
        {{ data.content }}
      </p>
    </div>
    <footer class="card-footer">
      <nuxt-link
        :to="{ name: 'berita-slug', params: { slug: data.slug } }"
        class="card-footer-item"
      >
        Selengkapnya...
      </nuxt-link>
    </footer>
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
};
</script>
