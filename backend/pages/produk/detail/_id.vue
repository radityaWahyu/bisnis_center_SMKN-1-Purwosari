<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="tags" :style="{ marginRight: '10px' }" />Detail Produk dan
        Jasa
      </h2>
      <div>
        <a-tooltip placement="left">
          <template slot="title">
            <span>Kembali ke Produk</span>
          </template>
          <a-button size="large" @click="back">
            <a-icon type="swap-left" :style="{ fontSize: '30px' }"></a-icon>
          </a-button>
        </a-tooltip>
      </div>
    </div>
    <a-row
      :gutter="24"
      :style="{
        marginTop: '10px',
        backgroundColor: '#FFFFFF',
        padding: '15px 5px 15px 5px',
        marginLeft: '0px',
        marginRight: '0px'
      }"
    >
      <a-col :span="9" class="image-detail">
        <img :src="image" alt="" v-if="image.length > 0" />
        <img src="~/assets/image/image_unavaible.png" alt="" v-else />
        <a-button
          type="primary"
          size="large"
          :style="{ marginTop: '10px' }"
          :loading="loadingBest"
          @click="setBest(row.id, 1)"
          block
          v-if="row.is_best === 0"
        >
          <a-icon type="star" v-if="!loadingBest"></a-icon>
          <span>Set Unggulan</span>
        </a-button>
        <a-button
          type="default"
          size="large"
          :style="{ marginTop: '15px' }"
          :loading="loadingBest"
          @click="setBest(row.id, 0)"
          block
          v-else-if="row.is_best === 1"
        >
          <a-icon type="star" v-if="!loadingBest"></a-icon>
          <span>Batalkan Unggulan</span>
        </a-button>
      </a-col>
      <a-col
        :span="14"
        :style="{
          borderLeft: 'dashed 2px #F0F2F5',
          minHeight: '500px'
        }"
      >
        <div v-if="loading">
          <a-skeleton
            loading
            :title="{ width: '400px' }"
            :paragraph="{ rows: 7 }"
            :avatar="false"
            active
          />
        </div>
        <div v-else>
          <h2
            :style="{
              textTransform: 'capitalize',
              margin: '0px',
              fontSize: '30px',
              marginTop: '-10px'
            }"
          >
            {{ row.title }}
          </h2>
          <div :style="{ marginBottom: '20px' }">
            <span :style="{ marginRight: '10px', textTransform: 'capitalize' }">
              <a-icon type="user" /> {{ row.user_name }} -
              {{ row.user_level }}
            </span>
            <span :style="{ marginRight: '10px', textTransform: 'capitalize' }">
              <a-icon type="clock-circle" /> {{ row.created }}
            </span>
            <span>
              <a-tag v-if="row.viewer === 0">
                <a-icon type="interaction" :style="{ marginRight: '5px' }" />
                0
              </a-tag>
              <a-tag color="#87d068" v-else>
                <a-icon type="interaction" :style="{ marginRight: '5px' }" />
                {{ row.viewer }}
              </a-tag>
            </span>
          </div>
          <div>
            <dl class="label">
              <dt>Kategori</dt>
              <dd>{{ row.category_name }}</dd>
              <dt>Jurusan</dt>
              <dd>{{ row.departement_name }}</dd>
              <dt>Deskripsi</dt>
              <dd>&nbsp;</dd>
            </dl>
          </div>
          <div :style="{ marginTop: '5px' }">
            <p
              v-html="row.description"
              :style="{ margin: '0px', lineHeight: '25px' }"
            ></p>
          </div>
        </div>
      </a-col>
    </a-row>
    <a-row
      class="bottom-detail"
      :gutter="24"
      :style="{ marginLeft: '0px', marginRight: '0px' }"
    >
      <a-col :span="9">
        <produk-gallery />
      </a-col>
      <a-col :span="15">
        <a-card title="ULASAN PENGUNJUNG" class="galery" :bordered="false">
          <produk-review :id="id"></produk-review>
        </a-card>
      </a-col>
    </a-row>
  </div>
</template>
<script>
export default {
  // middleware: "isAuth",
  head() {
    return {
      title: "Detail produk atau jasa",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Detail produk atau jasa"
        }
      ]
    };
  },
  data() {
    return {
      loadingBest: false,
      loading: false,
      image: "",
      row: [],
      id: ""
    };
  },
  components: {
    produkReview: () => import("~/components/produk/produkReview"),
    produkGallery: () => import("~/components/produk/produkGallery")
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
          // this.$store.commit("spinner/set_spinner", {
          //   show: true,
          //   text: "Ambil data..."
          // });
          const { data } = await this.$store.dispatch(
            "product/showProduct",
            id
          );
          this.row = data;
          if (data.image !== null) {
            this.image =
              process.env.IMAGE_URL + "/thumbnail/item/" + data.image;
          } else {
            this.image = "";
          }
        } catch (error) {
          console.log(error.response);
        }
        // this.$store.commit("spinner/set_spinner", {
        //   show: false,
        //   text: ""
        // });
        this.loading = false;
      }
    }
  },
  methods: {
    back() {
      this.$router.push({ name: "produk" });
    },
    async setBest(id, value) {
      try {
        this.loadingBest = true;
        const { data } = await this.$store.dispatch("product/setBest", {
          id,
          value
        });
        console.log(data);
        this.row.is_best = value;

        this.$notification.success({
          message: "Informasi",
          description: "Data produk berhasil di update"
        });
      } catch (error) {
        console.log(error);
      }
      this.loadingBest = false;
    }
  }
};
</script>
