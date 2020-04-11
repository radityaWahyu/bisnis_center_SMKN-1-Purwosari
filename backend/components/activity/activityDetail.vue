<template>
  <a-modal
    v-model="visible"
    :footer="null"
    :bodyStyle="{
      padding: '10px 10px 0px 10px',
      backgroundColor: '#F2F4F7',
      borderRadius: '0px 0px 3px 3px'
    }"
    :keyboard="false"
    :maskClosable="false"
    :afterClose="onClose"
    width="700px"
  >
    <template slot="title">
      <a-icon
        type="solution"
        :style="{ fontSize: '20px', marginRight: '5px' }"
      ></a-icon>
      <span :style="{ fontSize: '20px', fontWeight: '600' }">
        Detail Aktifitas User
      </span>
    </template>
    <a-skeleton
      :loading="loading"
      :title="false"
      :paragraph="{ rows: 4 }"
      :avatar="false"
      active
    />
    <div v-if="loading === false" class="activity-box">
      <div>
        <div>Subject:</div>
        <h3>{{ row.subject }}</h3>
      </div>
      <a-row>
        <a-col :span="12">
          <div>Jenis Aktifitas :</div>
          <a-tag
            color="#87d068"
            :style="{ textTransform: 'capitalize' }"
            v-if="row.type === 'updated'"
          >
            {{ row.type }}
          </a-tag>
          <a-tag
            color="#f50"
            :style="{ textTransform: 'capitalize' }"
            v-else-if="row.type === 'deleted'"
          >
            {{ row.type }}
          </a-tag>
          <a-tag
            color="#2db7f5"
            :style="{ textTransform: 'capitalize' }"
            v-else-if="row.type === 'created'"
          >
            {{ row.type }}
          </a-tag>
        </a-col>
        <a-col :span="12">
          <div>Modul :</div>
          <a-tag
            :style="{
              textTransform: 'capitalize'
            }"
          >
            {{ row.model }}
          </a-tag>
        </a-col>
      </a-row>
      <div :style="{ marginTop: '10px' }">
        <div>Nama user:</div>
        <h3>{{ row.user_name }}</h3>
      </div>
      <div>
        <div :style="{ marginBottom: '5px' }">Deskripsi :</div>
        <a-textarea
          placeholder="Basic usage"
          :rows="15"
          v-model="description"
          readonly
        />
      </div>
    </div>
  </a-modal>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      visible: false,
      loading: true,
      description: "",
      row: []
    };
  },
  created() {},
  methods: {
    ...mapActions("activity", ["getActivityDetail"]),
    async onShow(id) {
      this.loading = true;
      try {
        const { data } = await this.getActivityDetail(id);
        console.log(data);
        this.row = data;
        this.description = JSON.stringify(data.description, undefined, 4);
        this.loading = false;
        this.visible = true;
      } catch (error) {
        this.$notification.error({
          message: "Kesalahan",
          description: error.response
        });
      }
    },
    onClose() {}
  }
};
</script>
