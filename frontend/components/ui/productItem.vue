<template>
  <div class="item">
    <img
      :src="
        data.image != 0
          ? getImage('thumbnail/item/' + data.image)
          : getImage(null)
      "
      alt="gambar1"
    />
    <div class="description">
      <h5>{{ data.title }}</h5>
      <p>{{ data.departement_name }}</p>
    </div>
    <div class="link">
      <b-button type="is-primary" size="is-large" @click="onClick(data.slug)">
        <b-icon icon="eye" size="is-small"> </b-icon>
      </b-button>
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
    onClick(slug) {
      this.$router.push({ name: "detail-slug", params: { slug } });
    },
  },
};
</script>
