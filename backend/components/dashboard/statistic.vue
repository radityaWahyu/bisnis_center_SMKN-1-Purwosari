<template>
  <a-card :loading="loading">
    <a-statistic
      v-model="total"
      :precision="0"
      :suffix="suffix"
      class="statistic"
    >
      <template slot="title">
        <span :style="{ textTransform: 'uppercase' }">
          {{ type }}
        </span>
      </template>
      <template v-slot:prefix>
        <a-icon type="tag" v-if="type === 'produk'" />
        <a-icon type="book" v-else-if="type === 'berita'" />
        <a-icon type="user" v-else-if="type === 'user'" />
      </template>
    </a-statistic>
  </a-card>
</template>
<script>
import { mapActions } from "vuex";
export default {
  props: {
    type: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      total: 0,
      loading: false,
      suffix: "Data"
    };
  },
  async created() {
    if (this.type === "user") {
      this.suffix = "Orang";
    } else {
      this.suffix = "Data";
    }
    try {
      this.loading = true;
      const { count } = await this.getCount(this.type);
      // console.log(response);
      this.total = count;
    } catch (error) {
      console.log(error);
    }
    this.loading = false;
  },
  methods: {
    ...mapActions("dashboard", ["getCount"])
  }
};
</script>
