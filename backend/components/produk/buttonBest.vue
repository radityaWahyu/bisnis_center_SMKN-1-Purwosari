<template>
  <span>
    <a-button
      type="dashed"
      v-if="isBest === '1'"
      @click="setBest(id, '0')"
      :loading="loading.show"
    >
      <a-icon type="star" style="margin-right: 5px;" v-if="!loading.show" />
      <span v-if="loading.text.length > 0">
        {{ loading.text }}
      </span>
      <span v-else> Batalkan Unggulan </span>
    </a-button>
    <a-button
      type="primary"
      v-if="isBest === '0'"
      @click="setBest(id, '1')"
      :loading="loading.show"
    >
      <a-icon type="star" style="margin-right: 5px;" v-if="!loading.show" />
      <span v-if="loading.text.length > 0">
        {{ loading.text }}
      </span>
      <span v-else>
        Set Unggulan
      </span>
    </a-button>
  </span>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },
    dataBest: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isBest: "",
      loading: {
        show: false,
        text: ""
      }
    };
  },
  watch: {
    dataBest: {
      deep: true,
      immediate: true,
      handler(value) {
        this.isBest = value;
      }
    }
  },
  methods: {
    async setBest(id, value) {
      try {
        this.$notification.destroy();
        this.loading.show = true;
        this.loading.text = "Updating...";
        await this.$store.dispatch("product/setBest", {
          id,
          value
        });
        this.isBest = value;

        this.loading.text = "";
        this.loading.show = false;

        this.$notification.success({
          message: "Informasi",
          description: "Data produk berhasil di update",
          duration: 2
        });
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>
