<template>
  <div>
    <a-card :bordered="false" class="activityTable">
      <template slot="title">
        <a-icon type="message" :style="{ marginRight: '10px' }" />
        Ulasan Terbaru
      </template>
      <template slot="extra">
        <a-tooltip placement="left">
          <template slot="title">
            <span>Refresh Data</span>
          </template>
          <a-button icon="reload" @click="fetchData" />
        </a-tooltip>
      </template>
      <a-table
        :rowKey="record => record.id"
        :columns="columns"
        :dataSource="row"
        :pagination="false"
        :loading="loading"
        :scroll="{ y: 360 }"
        size="middle"
      >
        <template slot="pesan" slot-scope="text, record">
          <p :style="{ margin: '0px', fontWeight: '500', fontSize: '15px' }">
            {{ record.message }}
          </p>
          <p :style="{ margin: '10px 0px 0px 0px', fontSize: '13px' }">
            <span>
              <a-icon type="user" :style="{ marginRight: '5px' }" />
              {{ record.name }}
            </span>
            <span :style="{ marginLeft: '10px' }">
              <a-icon type="phone" :style="{ marginRight: '5px' }" />{{
                record.phone
              }}
            </span>
          </p>
          <p :style="{ margin: '0px', fontSize: '13px' }">
            Produk : {{ record.item_name }}
          </p>
        </template>
        <span slot="action" class="btn-action" slot-scope="text, record">
          <a-tooltip placement="right">
            <template slot="title">
              Balas Ulasan
            </template>
            <a-button type="primary" icon="retweet" @click="reply(record)" />
          </a-tooltip>
        </span>
      </a-table>
    </a-card>
    <reply-form ref="replyForm" @saved="replySaved" />
  </div>
</template>
<script>
import { mapActions } from "vuex";

const columns = [
  {
    title: "Ulasan",
    dataIndex: "message",
    key: "message",
    scopedSlots: { customRender: "pesan" }
  },
  {
    title: "",
    key: "aksi",
    scopedSlots: { customRender: "action" }
  }
];

export default {
  data() {
    return {
      columns,
      row: [],
      loading: false
    };
  },
  created() {
    this.fetchData();
  },
  components: {
    replyForm: () => import("~/components/review/replyForm")
  },
  methods: {
    ...mapActions("review", ["getLatest"]),
    async fetchData() {
      this.loading = true;
      try {
        //  Get data latest review from API
        const { data } = await this.getLatest("limit=5");
        this.row = data;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    reply(data) {
      this.$refs.replyForm.onCreate(data.id, data.item_id);
    },
    replySaved(data) {
      this.fetchData();
    }
  }
};
</script>
