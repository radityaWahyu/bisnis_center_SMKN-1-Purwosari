<template>
  <a-layout-sider width="80" id="sidebar">
    <a-row
      :style="{
        backgroundColor: '#271232',
        paddingTop: '10px',
        paddingBottom: '20px'
      }"
    >
      <a-col :span="24" :style="{ textAlign: 'center' }">
        <a-avatar
          :size="50"
          shape="square"
          class="avatar"
          :src="getAvatar(user.image)"
        />
      </a-col>
    </a-row>
    <a-menu
      theme="dark"
      mode="inline"
      :defaultSelectedKeys="isActive"
      :defaultOpenKeys="['sub1']"
      :style="{ height: '100%', borderRight: 0 }"
    >
      <a-menu-item
        key="1"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('dashboard')"
      >
        <a-icon
          type="home"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>Beranda</div>
      </a-menu-item>
      <!-- <a-menu-item
        key="2"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
      >
        <a-icon
          type="bars"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>Kategori</div>
      </a-menu-item> -->
      <a-menu-item
        v-if="user.level === 'admin'"
        key="3"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('jurusan')"
      >
        <a-icon
          type="deployment-unit"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>Jurusan</div>
      </a-menu-item>
      <a-menu-item
        key="4"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('produk')"
      >
        <a-icon
          type="tags"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>Produk</div>
      </a-menu-item>
      <a-menu-item
        key="5"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('berita')"
      >
        <a-icon
          type="book"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>Berita</div>
      </a-menu-item>
      <a-menu-item
        v-if="user.level === 'admin'"
        key="6"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('user')"
      >
        <a-icon
          type="user"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div>User</div>
      </a-menu-item>
      <a-menu-item
        v-if="user.level === 'admin'"
        key="7"
        :style="{
          height: '80px',
          paddingLeft: '10px',
          lineHeight: '25px',
          fontWeight: '500',
          textAlign: 'center'
        }"
        @click="gotoPage('activity')"
      >
        <a-icon
          type="solution"
          :style="{ fontSize: '30px', marginLeft: '5px', marginTop: '10px' }"
        />
        <div :style="{ lineHeight: '20px' }">
          Riwayat
          <br />User
        </div>
      </a-menu-item>
    </a-menu>
  </a-layout-sider>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";

export default {
  computed: {
    ...mapGetters({
      user: "auth/get_user",
      isActive: "navigation/get_active"
    })
  },
  methods: {
    ...mapMutations("navigation", ["set_active"]),
    gotoPage(url) {
      this.$router.push({ name: url });
    }
  }
};
</script>
