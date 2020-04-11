<template>
  <a-layout-header
    class="header"
    :style="{
      position: 'fixed',
      zIndex: 1,
      width: '100%',
      background: '#edeff2',
      padding: '0px',
      height: '50px',
      borderBottom: '2px solid #e8eaed',
      lineHeight: '50px'
    }"
  >
    <a-row type="flex" justify="space-between" align="top">
      <a-col :span="4" :style="{ height: '50px' }">
        <h2
          :style="{
            marginLeft: '10px',
            fontWeight: '600',
            fontSize: '20px',
            color: '#271232'
          }"
        >
          PusatBisnis
        </h2>
      </a-col>
      <a-col :span="5" :style="{ height: '50px' }">
        <a-menu
          mode="horizontal"
          :style="{
            backgroundColor: 'transparent',
            position: 'absolute',
            right: '0px'
          }"
        >
          <a-sub-menu>
            <span slot="title" :style="{ fontSize: '15px', fontWeight: '500' }">
              <a-icon type="user" />
              {{ user.name }}
              <br />
            </span>
            <a-menu-item @click="editProfil">
              <a-icon type="profile" />Edit Profil
            </a-menu-item>
            <a-menu-item :style="{ paddingLeft: '5px', paddingRight: '5px' }">
              <a-button
                size="large"
                block
                type="primary"
                :style="{ marginBottom: '10px' }"
                @click="logout"
              >
                <a-icon
                  type="logout"
                  :style="{ fontSize: '16px', fontWeight: 'bold' }"
                />Keluar Sistem
              </a-button>
            </a-menu-item>
          </a-sub-menu>
        </a-menu>
      </a-col>
    </a-row>
  </a-layout-header>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      user: "auth/get_user"
    })
  },
  methods: {
    editProfil() {
      this.$router.push({ name: "profil-id", params: { id: this.user.id } });
    },
    async logout() {
      this.$store.commit("spinner/set_spinner", {
        show: true,
        text: "Keluar Sistem..."
      });

      try {
        // call action VUEX logout
        await this.$store.dispatch("auth/logout");

        this.$store.commit("spinner/set_spinner", {
          show: false,
          text: ""
        });

        // redirect to login page
        this.$router.push({ path: "/" });
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>
