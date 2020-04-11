<template>
  <div>
    <h2 :style="{ fontSize: '22px', fontWeight: '600', marginBottom: '15px' }">
      <a-icon type="home" :style="{ marginRight: '10px' }" />Dashboard
    </h2>
    <a-row :gutter="24">
      <a-col :span="8">
        <statistic type="produk" />
      </a-col>
      <a-col :span="8">
        <statistic type="berita" />
      </a-col>
      <a-col :span="8">
        <statistic type="user" v-if="user.level === 'admin'" />
        <a-alert v-else-if="user.level === 'operator'" type="info" showIcon>
          <template slot="message">
            Informasi Pengguna :
          </template>
          <template slot="description">
            <span :style="{ fontSize: '13px' }">
              Selamat Datang <strong>{{ user.name }}</strong
              >, anda saat ini menggunakan level <strong>Operator</strong> yang
              hanya diijinkan untuk memanajemen <strong>Berita</strong> dan
              <strong>Produk</strong>.
            </span>
          </template>
        </a-alert>
      </a-col>
    </a-row>
    <a-row :gutter="24" :style="{ marginTop: '20px' }">
      <a-col :span="14">
        <graph />
      </a-col>
      <a-col :span="10">
        <review-table />
      </a-col>
    </a-row>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  layout: "master",
  head() {
    return {
      title: "Beranda User",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Beranda user"
        }
      ]
    };
  },
  computed: {
    ...mapGetters({
      user: "auth/get_user"
    })
  },
  components: {
    statistic: () => import("~/components/dashboard/statistic"),
    graph: () => import("~/components/dashboard/graph"),
    reviewTable: () => import("~/components/dashboard/reviewTable")
  }
};
</script>
