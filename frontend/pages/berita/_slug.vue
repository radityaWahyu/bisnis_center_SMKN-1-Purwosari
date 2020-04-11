<template>
  <section>
    <div class="header">
      <div class="container"></div>
    </div>
    <div class="content container">
      <div class="detail-news">
        <div class="image">
          <img
            v-if="loading"
            src="~/assets/image/no_image.png"
            alt="no_image"
            class="no-cover"
          />
          <img
            v-else
            :src="
              data.image != 0
                ? getImage('image/post/' + data.image)
                : getImage(null)
            "
            :alt="data.slug"
          />
          <div class="title" v-if="loading">
            <PuSkeleton width="500px" />
            <PuSkeleton height="5px" />
          </div>
          <div class="title" v-else>
            <h4>{{ data.title }}</h4>
            <h5>{{ data.departement_name }}</h5>
          </div>
        </div>
        <div
          v-if="loading"
          :style="{ marginTop: '40px', marginBottom: '40px' }"
        >
          <PuSkeleton :count="8" />
        </div>
        <div v-else class="content" v-html="data.content"></div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  async fetch() {
    try {
      this.loading = true;
      const { data } = await this.$store.dispatch(
        "news/showNews",
        this.$route.params.slug
      );
      this.data = data;
    } catch (error) {
      console.log(error);
    }
    this.loading = false;
  },
  head() {
    return {
      title: this.data.title,
      meta: [
        {
          hid: "description",
          name: "description",
          content: this.data.title,
        },
      ],
    };
  },
  data() {
    return {
      loading: false,
      data: [],
    };
  },
};
</script>
