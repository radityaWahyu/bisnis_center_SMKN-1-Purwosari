<template>
  <div>
    <a-skeleton
      :loading="loading"
      :title="{ width: '400px' }"
      :paragraph="{ rows: 2 }"
      :avatar="false"
      active
    />
    <div v-if="!loading">
      <div v-if="row.length > 0">
        <a-comment
          v-for="review in row"
          :key="review.id"
          :style="{ borderBottom: '1px dashed #CCCCCC' }"
        >
          <span slot="actions">
            <a-button
              type="primary"
              v-if="review.is_reply === 0"
              @click="reply(review.id)"
            >
              <a-icon type="retweet" />
              Balas Ulasan
            </a-button>
            <a-button @click="deleteReview(review.id)">
              <a-icon type="close-circle" />
              Hapus
            </a-button>
          </span>
          <p slot="author">{{ review.name }} - {{ review.phone }}</p>
          <p slot="datetime">{{ review.created }}</p>
          <a-avatar slot="avatar" style="backgroundColor:#87d068" icon="user" />
          <p slot="content" :style="{ whiteSpace: 'unset', fontSize: '17px' }">
            {{ review.message }}
          </p>
          <a-divider
            :style="{ marginTop: '-10px' }"
            v-if="review.reply.length > 0"
          />
          <div v-if="review.reply.length > 0" :style="{ marginTop: '-30px' }">
            <a-comment v-for="reply in review.reply" :key="reply.id">
              <p slot="author">{{ reply.name }} - {{ reply.phone }}</p>
              <p slot="datetime">{{ reply.created_at }}</p>
              <a-avatar slot="avatar" icon="enter" shape="square" />
              <p
                slot="content"
                :style="{ whiteSpace: 'unset', fontSize: '17px' }"
              >
                {{ reply.message }}
              </p>
              <span slot="actions">
                <a-button @click="deleteReply(reply.id, review.id)">
                  <a-icon type="close-circle" />
                  Hapus
                </a-button>
              </span>
            </a-comment>
          </div>
        </a-comment>
      </div>
      <a-alert
        v-else
        message="Informasi"
        description="Tidak terdapat ulasan terhadap produk / jasa ini...."
        type="warning"
        showIcon
      />
      <reply-form ref="replyForm" @saved="replySaved" />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      row: [],
      loading: false
    };
  },
  components: {
    replyForm: () => import("~/components/review/replyForm")
  },
  created() {
    this.getReview();
  },
  methods: {
    async getReview() {
      try {
        this.loading = true;
        const { data } = await this.$store.dispatch(
          "review/getReview",
          this.id
        );
        this.row = data;
        console.log(data);
      } catch (error) {
        console.log(error.response);
      }
      this.loading = false;
    },
    async deleteReply(id, idReview) {
      try {
        await this.$store.dispatch("review/deleteReview", {
          id,
          id_review: idReview,
          type: "reply"
        });

        this.getReview();
      } catch (error) {
        console.log(error.response);
      }
    },
    async deleteReview(id) {
      try {
        await this.$store.dispatch("review/deleteReview", {
          id,
          type: "review"
        });
        this.getReview();
      } catch (error) {
        console.log(error.response);
      }
    },
    reply(idReview) {
      this.$refs.replyForm.onCreate(idReview, this.id);
    },
    replySaved(data) {
      this.getReview();
    }
  }
};
</script>
