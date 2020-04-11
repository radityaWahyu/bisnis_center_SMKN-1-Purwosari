<template>
  <a-card class="activityTable">
    <div slot="title" v-if="userId.length > 0">
      <a-icon type="solution" />
      <span>
        Riwayat User
      </span>
    </div>
    <a-table
      :rowKey="record => record.id"
      :columns="columns"
      :dataSource="row"
      :pagination="paginate"
      :loading="loading"
      @change="handleTableChange"
      size="small"
    >
      <span slot="user" slot-scope="text, record" class="capitalize">
        {{ record.user_name }}
      </span>
      <span slot="aksi" slot-scope="text, record">
        <a-tag
          color="#2db7f5"
          v-if="record.type === 'created'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.type }}
        </a-tag>
        <a-tag
          color="#f50"
          v-else-if="record.type === 'deleted'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.type }}
        </a-tag>
        <a-tag
          color="#87d068"
          v-else-if="record.type === 'updated'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.type }}
        </a-tag>
        <a-tag
          color="#F7AE5F"
          v-else-if="record.type === 'logout'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.type }}
        </a-tag>
        <a-tag color="#40A8FB" v-else :style="{ textTransform: 'capitalize' }">
          {{ record.type }}
        </a-tag>
      </span>
      <span slot="model" slot-scope="text, record" class="capitalize">
        <a-tag
          :style="{ textTransform: 'capitalize' }"
          @click="showDetail(record.id)"
        >
          {{ record.model }}
        </a-tag>
      </span>
    </a-table>
    <activity-detail ref="activityDetail" />
  </a-card>
</template>
<script>
import { mapActions } from "vuex";

const columns = [
  {
    title: "Nama User",
    dataIndex: "user_name",
    sorter: true,
    key: "user_name",
    width: "25%",
    scopedSlots: { customRender: "user" }
  },
  {
    title: "Aktivitas",
    dataIndex: "type",
    sorter: false,
    key: "type",
    scopedSlots: { customRender: "aksi" }
  },
  {
    title: "Modul",
    dataIndex: "model",
    sorter: true,
    key: "model",
    scopedSlots: { customRender: "model" }
  },
  {
    title: "Ip Address",
    dataIndex: "ip_address",
    sorter: false,
    key: "ip_address"
  },
  {
    title: "Browser Name",
    dataIndex: "browser_name",
    sorter: false,
    key: "browser_name"
  },
  {
    title: "Operating System",
    dataIndex: "os_name",
    sorter: false,
    key: "os_name"
  },
  {
    title: "Tanggal",
    dataIndex: "created",
    sorter: false,
    key: "created"
  }
];

export default {
  data() {
    return {
      columns,
      row: [],
      userId: "",
      loading: false,
      sortField: "created_at",
      sortOrder: "desc",
      paginate: {
        size: "default",
        pageSize: 10,
        total: 0,
        current: 1,
        showSizeChanger: true,
        pageSizeOptions: ["10", "20", "30", "40", "50"],
        showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} data`
      }
    };
  },
  props: {
    user: {
      type: String,
      required: false
    }
  },
  watch: {
    user: {
      deep: true,
      immediate: true,
      handler(value) {
        if (value !== undefined) {
          this.userId = value;
        }

        this.fetchData();
      }
    }
  },
  components: {
    activityDetail: () => import("~/components/activity/activityDetail")
  },
  methods: {
    ...mapActions("activity", ["getActivity"]),
    handleTableChange(pagination, filters, sorter) {
      this.sortField = sorter.field === undefined ? "created_at" : sorter.field;
      this.sortOrder = sorter.order === "ascend" ? "asc" : "desc";
      this.paginate.current = pagination.current;
      this.paginate.pageSize = pagination.pageSize;
      this.fetchData();
    },
    async fetchData() {
      let url = "";
      this.loading = true;

      const params = [
        `sort=${this.sortField}`,
        `direction=${this.sortOrder}`,
        `page=${this.paginate.current}`,
        `per_page=${this.paginate.pageSize}`
      ].join("&");

      url = params;

      if (this.userId.length > 0) {
        const filter = `user=${this.userId}`;
        url = `${url}&${filter}`;
      }

      try {
        //  Get data departemen from API
        const { data, meta } = await this.getActivity(url);
        this.row = data;
        this.paginate.total = meta.total;
        this.paginate.pageSize = meta.per_page;
        this.paginate.current = meta.current_page;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    showDetail(id) {
      this.$refs.activityDetail.onShow(id);
    }
  }
};
</script>
