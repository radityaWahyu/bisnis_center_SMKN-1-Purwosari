<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="book" :style="{ marginRight: '10px' }" />Halaman berita
      </h2>
      <div>
        <a-tooltip placement="left">
          <template slot="title">
            <span>Kembali ke Berita</span>
          </template>
          <a-button size="large" @click="back">
            <a-icon type="swap-left" :style="{ fontSize: '30px' }"></a-icon>
          </a-button>
        </a-tooltip>
      </div>
    </div>
    <div class="berita">
      <a-skeleton
        :loading="loading"
        :title="false"
        :paragraph="{ rows: 7 }"
        :avatar="false"
        active
        class="skelton"
      />
      <div class="jumbotron" v-if="!loading">
        <img :src="image" alt="" v-if="image.length > 0" />
        <img src="~/assets/image/image_unavaible.png" alt="" v-else />
        <div class="title">
          <h2>{{ row.title }}</h2>
          <p>Tanggal Rilis {{ row.created }}</p>
        </div>
      </div>
      <div class="content" v-html="row.content" v-if="!loading"></div>
    </div>
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  head() {
    return {
      title: "Detail Berita",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Halaman detail Berita"
        }
      ]
    };
  },
  data() {
    return {
      loading: true,
      image: "",
      row: [],
      id: ""
    };
  },
  created() {
    this.id = this.$route.params.id;
  },
  watch: {
    "$route.params.id": {
      deep: true,
      immediate: true,
      async handler(id) {
        try {
          this.loading = true;
          const { data } = await this.$store.dispatch("news/showPost", id);
          this.loading = false;
          this.row = data;
          if (data.image !== null) {
            this.image = process.env.IMAGE_URL + "/image/post/" + data.image;
          } else {
            this.image = "";
          }
        } catch (error) {
          console.log(error.response);
        }
        this.loading = false;
      }
    }
  },
  methods: {
    back() {
      this.$router.push({ name: "berita" });
    }
  }
};
</script>
