<template>
  <div class="top-nav">
    <nav
      class="navbar container"
      role="navigation"
      aria-label="main navigation"
    >
      <div class="navbar-menu">
        <div class="navbar-end">
          <nuxt-link
            to="/"
            class="navbar-item"
            v-bind:class="{ active: menuActive === 'beranda' }"
            >Beranda</nuxt-link
          >
          <nuxt-link
            :to="{ name: 'produk' }"
            class="navbar-item"
            v-bind:class="{ active: menuActive === 'produk' }"
          >
            Produk
          </nuxt-link>
          <nuxt-link
            :to="{ name: 'jasa' }"
            class="navbar-item"
            v-bind:class="{ active: menuActive === 'jasa' }"
          >
            Jasa
          </nuxt-link>
        </div>
      </div>
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          <img src="~assets/image/logo.png" alt="PusatBisnis" />
        </a>
        <div class="burger-link" @click="openNav">
          <b-icon icon="text" size="is-large"> </b-icon>
        </div>
        <div class="sub-brand">
          SMK NEGERI 1 PURWOSARI PASURUAN
        </div>
      </div>
      <div class="navbar-menu">
        <div class="navbar-start">
          <b-dropdown hoverable aria-role="list" class="menu-departement">
            <a
              href=""
              class="navbar-item"
              slot="trigger"
              v-bind:class="{ active: menuActive === 'jurusan' }"
              >Jurusan</a
            >
            <b-dropdown-item
              aria-role="listitem"
              v-for="item in departement"
              :key="item.id"
              @click="gotoPage(item.id)"
            >
              <b-icon icon="bookmark" size="is-small"> </b-icon>
              {{ item.departement }}
            </b-dropdown-item>
          </b-dropdown>
          <nuxt-link
            to="/berita"
            class="navbar-item"
            v-bind:class="{ active: menuActive === 'berita' }"
            >Berita</nuxt-link
          >
          <nuxt-link
            to="/kontak"
            class="navbar-item"
            v-bind:class="{ active: menuActive === 'kontak' }"
            >Kontak</nuxt-link
          >
        </div>
      </div>
    </nav>
    <div class="burger-nav" v-if="burger">
      <div class="burger-link" @click="closeNav">
        <b-icon icon="close" size="is-large"> </b-icon>
      </div>
      <b-sidebar
        position="static"
        :mobile="mobile"
        :expand-on-hover="expandOnHover"
        :reduce="reduce"
        type="is-light"
        open
      >
        <div class="p-1">
          <b-menu class="is-custom-mobile">
            <b-menu-list label="Menu">
              <b-menu-item
                label="BERANDA"
                @click="page('index')"
                :active="menuActive === 'beranda'"
              ></b-menu-item>
              <b-menu-item
                label="PRODUK"
                @click="page('produk')"
                :active="menuActive === 'produk'"
              ></b-menu-item>
              <b-menu-item
                label="JASA"
                @click="page('jasa')"
                :active="menuActive === 'jasa'"
              ></b-menu-item>
              <b-menu-item
                :active="menuActive === 'jurusan'"
                :expanded="menuActive === 'jurusan'"
                label="JURUSAN"
              >
                <b-menu-item
                  v-for="item in departement"
                  :key="item.id"
                  :label="item.departement"
                  @click="gotoPage(item.id)"
                ></b-menu-item>
              </b-menu-item>
              <b-menu-item
                label="BERITA"
                @click="page('berita')"
                :active="menuActive === 'berita'"
              ></b-menu-item>
              <b-menu-item
                label="KONTAK"
                @click="page('kontak')"
                :active="menuActive === 'kontak'"
              ></b-menu-item>
            </b-menu-list>
          </b-menu>
        </div>
      </b-sidebar>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      departement: "departement/getDepartement",
      burger: "getBurger",
      menuActive: "getActiveNav",
    }),
  },
  methods: {
    gotoPage(departementId) {
      this.$store.commit("setBurger", false);
      this.$router.push({ name: "jurusan-id", params: { id: departementId } });
    },
    openNav() {
      this.$store.commit("setBurger", true);
    },
    closeNav() {
      this.$store.commit("setBurger", false);
    },
    page(link) {
      this.$store.commit("setBurger", false);
      this.$router.push({ name: link });
    },
  },
};
</script>
