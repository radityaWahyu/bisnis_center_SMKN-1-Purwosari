<template>
  <span>
    <a-button
      type="dashed"
      v-if="publish === 1"
      @click="setPublish(id, 0)"
      :loading="loading.show"
    >
      <a-icon type="save" style="margin-right: 5px;" v-if="!loading.show" />
      <span v-if="loading.text.length > 0">
        {{ loading.text }}
      </span>
      <span v-else>
        Jadikan draft
      </span>
    </a-button>
    <a-button
      type="primary"
      v-if="publish === 0"
      @click="setPublish(id, 1)"
      :loading="loading.show"
    >
      <a-icon
        type="file-done"
        style="margin-right: 5px;"
        v-if="!loading.show"
      />
      <span v-if="loading.text.length > 0">
        {{ loading.text }}
      </span>
      <span v-else>
        Tampilkan berita
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
      type: Number,
      required: true
    }
  },
  data() {
    return {
      publish: "",
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
        this.publish = value;
      }
    }
  },
  methods: {
    async setPublish(id, value) {
      try {
        this.$notification.destroy();
        this.loading.show = true;
        this.loading.text = "Updating...";
        await this.$store.dispatch("news/setPublish", {
          id,
          value
        });
        this.publish = value;

        this.loading.text = "";
        this.loading.show = false;

        this.$notification.success({
          message: "Informasi",
          description: "Berita berhasil di update",
          duration: 2
        });
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>
