<template>
  <section>
    <b-message
      v-if="review.length > 0"
      type="is-info"
      :style="{ marginLeft: '12px', fontWeight: '500', fontSize: '14px' }"
    >
      Silahkan untuk memberikan ulasan dengan menekan tombol
      <strong>Tambah Ulasan</strong><br />
      <b-button
        type="is-default"
        icon-left="message-plus"
        :style="{ marginTop: '10px' }"
        @click="addReview"
      >
        Tambah Ulasan
      </b-button>
    </b-message>
    <div v-if="loading" :style="{ width: '50%', marginLeft: '15px' }">
      <PuSkeleton width="50%" height="8px" />
      <PuSkeleton :count="2" />
    </div>
    <div v-else>
      <div v-if="review.length !== 0">
        <div :style="{ width: '70%' }" v-for="item in review" :key="item.id">
          <div class="review">
            <div class="avatar image is-48x48">
              <img class="is-rounded" src="~/assets/image/avatar.png" />
            </div>
            <div class="message">
              <p class="info">
                <span> {{ item.name }} - {{ item.phone }} </span>
                <span>
                  {{ item.created }}
                </span>
              </p>
              <p>{{ item.message }}</p>
            </div>
          </div>
          <div class="review reply" v-if="item.reply.length > 0">
            <div class="avatar image is-48x48">
              <img class="is-rounded" src="~/assets/image/avatar.png" />
            </div>
            <div class="message">
              <p class="info">
                <span>
                  {{ item.reply[0].name }} - {{ item.reply[0].phone }}
                </span>
                <span>
                  {{ item.reply[0].created_at }}
                </span>
              </p>
              <p>{{ item.reply[0].message }}</p>
            </div>
          </div>
        </div>
        <b-pagination
          :total="meta.total"
          :current.sync="meta.current_page"
          :per-page="meta.per_page"
          class="paging"
          simple
          @change="changePage"
        >
          <b-pagination-button
            slot="previous"
            slot-scope="props"
            :page="props.page"
            :style="{ padding: '5px 20px' }"
          >
            Sebelumnya
          </b-pagination-button>
          <b-pagination-button
            slot="next"
            slot-scope="props"
            :page="props.page"
            :style="{ padding: '5px 20px' }"
          >
            Selanjutnya
          </b-pagination-button>
        </b-pagination>
      </div>
    </div>
    <b-message
      v-if="reviewLength === 0"
      type="is-info"
      has-icon
      :style="{ marginLeft: '14px' }"
    >
      <h5 :style="{ marginBottom: '0px' }">Informasi :</h5>
      <p :style="{ fontSize: '14px' }">
        Maaf, Belum terdapat ulasan terhadap produk atau jasa ini.<br />
        Silahkan untuk memberikan ulasan dengan menekan tombol
        <strong>Tambah Ulasan</strong><br />
        <b-button
          type="is-default"
          icon-left="message-plus"
          :style="{ marginTop: '10px' }"
          @click="addReview"
        >
          Tambah Ulasan
        </b-button>
      </p>
    </b-message>
    <review-form ref="reviewForm" :id="id" @success="onSuccess" />
  </section>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
      validator: (value) => {
        // Only accepts values that contain the string 'cookie-dough'.
        console.log(value);
        return true;
      },
    },
  },
  data() {
    return {
      review: [],
      reviewLength: 1,
      loading: false,
      meta: [],
    };
  },
  watch: {
    id: {
      immediate: true,
      handler(value) {
        if (value !== "undefined") {
          this.changePage(1);
        }
      },
    },
  },
  components: {
    reviewForm: () => import("~/components/product/reviewForm"),
  },
  methods: {
    async changePage(page) {
      try {
        this.loading = true;
        const { data, meta } = await this.$store.dispatch(
          "review/getReview",
          `id=${this.id}&page=${page}`
        );
        this.reviewLength = data.length;
        this.review = data;
        this.meta = meta;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    addReview() {
      this.$refs.reviewForm.showForm(true);
    },
    onSuccess(data) {
      this.changePage(1);
    },
  },
};
</script>
