<template>
  <section>
    <div class="header">
      <div class="container">
        <h3 class="title">JURUSAN {{ departement.departement }}</h3>
      </div>
    </div>
    <div class="content container">
      <div class="title">
        <p>
          Berisikan daftar <strong>Product</strong> dan
          <strong>Jasa</strong> yang di sediakan oleh jurusan
          <strong>{{ departement.departement }}</strong> pada SMKN 1 Purwosari.
        </p>
      </div>
      <!-- show message when fetch action failed -->
      <b-message type="is-info" has-icon v-if="$fetchState.error">
        <h5 :style="{ marginBottom: '0px' }">Kesalahan :</h5>
        <p :style="{ fontSize: '14px' }">
          <strong>Pesan Kesalahan : </strong> {{ $fetchState.error.message }}
        </p>
      </b-message>
      <!-- show message when not data present -->
      <b-message type="is-info" has-icon v-if="rowLength === 0">
        <h5 :style="{ marginBottom: '0px' }">Informasi :</h5>
        <p :style="{ fontSize: '14px' }">
          Maaf, Belum terdapat data <strong>Produk dan Jasa</strong> yang
          disimpan kedalam sistem.
        </p>
      </b-message>
      <div class="gallery" v-else>
        <product-item v-for="item in row" :key="item.id" :data="item" />
        <!-- show loader when fetch data -->
        <b-loading :is-full-page="false" :active="loading"></b-loading>
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
  </section>
</template>
<script>
export default {
  head() {
    return {
      title: `Jurusan ${this.departement.departement}`,
      meta: [
        {
          hid: "description",
          name: "description",
          content: `Daftar Produk dan Jasa yang disediakan oleh jurusan ${this.departement.departement}`,
        },
      ],
    };
  },
  data() {
    return {
      departement: [],
      row: [],
      meta: [],
      links: [],
      rowLength: 1,
      loading: false,
    };
  },
  async fetch() {
    try {
      this.loading = true;
      const [departement, product] = await Promise.all([
        this.$store.dispatch(
          "departement/showDepartement",
          this.$route.query.id
        ),
        this.$store.dispatch(
          "product/getProduct",
          `departement=${this.$route.query.id}&paginate=true&limit=8`
        ),
      ]);
      this.departement = departement.data;
      this.row = product.data;
      this.meta = product.meta;
      this.links = product.links;
      this.rowLength = product.data.length;
      // console.log(product);
    } catch (error) {
      console.log("error");
    }
    this.loading = false;
  },
  components: {
    productItem: () => import("~/components/ui/productItem"),
  },
  methods: {
    async changePage(data) {
      try {
        this.loading = true;
        const product = await this.$store.dispatch(
          "product/getProduct",
          `departement=${this.$route.params.id}&paginate=true&limit=8&page=${data}`
        );
        this.row = product.data;
        this.meta = product.meta;
        this.links = product.links;
        this.rowLength = product.data.length;
        // console.log(product);
      } catch (error) {
        console.log("error");
      }
      this.loading = false;
    },
  },
};
</script>
