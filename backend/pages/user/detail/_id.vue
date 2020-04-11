<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="user" :style="{ marginRight: '10px' }" />Detail User
      </h2>
      <div>
        <a-tooltip placement="left">
          <template slot="title">
            <span>Kembali ke User</span>
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
        marginLeft: '4px',
        marginRight: '4px'
      }"
    >
      <a-col :span="8" class="image-detail">
        <img :src="image" alt="" v-if="image.length > 0" />
        <img src="~/assets/image/image_unavaible.png" alt="" v-else />
      </a-col>
      <a-col
        :span="15"
        :style="{
          borderLeft: 'dashed 2px #F0F2F5',
          minHeight: '450px'
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
          <div>
            <div :style="{ fontSize: '14px' }">
              Nama Lengkap :
            </div>
            <h2
              :style="{
                fontSize: '24px',
                textTransform: 'capitalize'
              }"
            >
              <a-icon type="user" :style="{ marginRight: '10px' }" />{{
                row.name
              }}
            </h2>
          </div>
          <a-row :style="{ marginTop: '15px' }">
            <a-col :span="12">
              <div>
                <div :style="{ fontSize: '14px' }">
                  Email atau Username :
                </div>
                <h2
                  :style="{
                    fontSize: '24px'
                  }"
                >
                  <a-icon type="mail" :style="{ marginRight: '10px' }" />{{
                    row.email
                  }}
                </h2>
              </div>
            </a-col>
            <a-col :span="12">
              <div>
                <div :style="{ fontSize: '14px' }">
                  No Handphone atau Whatsapp :
                </div>
                <h2
                  :style="{
                    fontSize: '24px',
                    textTransform: 'capitalize'
                  }"
                >
                  <a-icon type="phone" :style="{ marginRight: '10px' }" />{{
                    row.phone
                  }}
                </h2>
              </div>
            </a-col>
          </a-row>
          <div :style="{ marginTop: '15px' }">
            <div :style="{ fontSize: '14px' }">
              Jurusan :
            </div>
            <h2
              :style="{
                fontSize: '24px',
                textTransform: 'capitalize'
              }"
            >
              <a-icon type="deployment-unit" :style="{ marginRight: '10px' }" />
              {{ row.departement_name }}
            </h2>
          </div>
          <div :style="{ marginTop: '15px' }">
            <div :style="{ fontSize: '14px' }">
              Level user :
            </div>
            <h2
              :style="{
                fontSize: '20px',
                textTransform: 'capitalize',
                color: '#108ee9'
              }"
            >
              <a-icon type="team" :style="{ marginRight: '10px' }" />
              {{ row.level }}
            </h2>
          </div>
          <a-row :style="{ marginTop: '100px' }">
            <a-col :span="12">
              <div>
                <div :style="{ fontSize: '14px' }">
                  Tanggal dibuat :
                </div>
                <h2
                  :style="{
                    fontSize: '18px'
                  }"
                >
                  <a-icon
                    type="clock-circle"
                    :style="{ marginRight: '10px' }"
                  />
                  {{ row.created }}
                </h2>
              </div>
            </a-col>
            <a-col :span="12">
              <div>
                <div :style="{ fontSize: '14px' }">
                  Tanggal di update :
                </div>
                <h2
                  :style="{
                    fontSize: '18px',
                    textTransform: 'capitalize'
                  }"
                >
                  <a-icon
                    type="clock-circle"
                    :style="{ marginRight: '10px' }"
                  />
                  {{ row.updated }}
                </h2>
              </div>
            </a-col>
          </a-row>
        </div>
      </a-col>
    </a-row>
    <activity-table :user="id" />
  </div>
</template>
<script>
export default {
  middleware: "isAdmin",
  head() {
    return {
      title: "Detail user",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Detail user"
        }
      ]
    };
  },
  data() {
    return {
      loading: false,
      image: "",
      row: [],
      id: ""
    };
  },
  components: {
    activityTable: () => import("~/components/activity/activityTable")
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
          const { data } = await this.$store.dispatch("user/showUser", id);
          this.row = data;
          if (data.image !== null) {
            this.image = process.env.IMAGE_URL + "/image/user/" + data.image;
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
      this.$router.push({ name: "user" });
    }
  }
};
</script>
