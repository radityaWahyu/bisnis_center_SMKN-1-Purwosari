<template>
  <a-card id="datatable">
    <div slot="title">
      <a-row type="flex" justify="space-between" align="middle">
        <a-col :span="10">
          <a-input-search
            placeholder="Cari jurusan..."
            @search="onSearch"
            v-model="search"
          />
          <a-tooltip>
            <template slot="title">
              Refresh
            </template>
            <a-button type="primary" @click="refresh">
              <a-icon type="reload" :style="{ fontSize: '16px' }"></a-icon>
            </a-button>
          </a-tooltip>
        </a-col>
      </a-row>
    </div>
    <a-table
      :rowKey="record => record.id"
      :rowSelection="{
        selectedRowKeys: selectedRowKeys,
        onChange: onSelectChange
      }"
      :columns="columns"
      :dataSource="row"
      :pagination="paginate"
      :loading="loading"
      @change="handleTableChange"
      size="middle"
    >
      <span slot="action" class="btn-action" slot-scope="text, record">
        <a-tooltip placement="right">
          <template slot="title">
            Edit
          </template>
          <a-button type="dashed" shape="circle" @click="onEdit(record.id)">
            <a-icon type="edit" :style="{ fontSize: '15px' }"></a-icon>
          </a-button>
        </a-tooltip>
      </span>
    </a-table>
  </a-card>
</template>
<script>
import { mapActions } from "vuex";

const columns = [
  {
    title: "Jurusan",
    dataIndex: "departement",
    sorter: true,
    key: "departement"
  },
  {
    title: "Aksi",
    key: "aksi",
    scopedSlots: { customRender: "action" }
  }
];

export default {
  data() {
    return {
      search: "",
      columns,
      selectedRowKeys: [],
      row: [],
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
  created() {
    this.fetchData();
  },
  computed: {},
  methods: {
    ...mapActions("departement", ["getDepartement"]),
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

      if (this.search.length > 0) {
        const search = `search=${this.search}`;
        url = `${params}&${search}`;
      } else {
        url = `${params}`;
      }

      try {
        //  Get data departemen from API
        const { data, meta } = await this.getDepartement(url);
        this.row = data;
        this.paginate.total = meta.total;
        this.paginate.pageSize = meta.per_page;
        this.paginate.current = meta.current_page;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    onSelectChange(row) {
      this.selectedRowKeys = row;
      this.$emit("selectedRow", this.selectedRowKeys);
    },
    onCancel() {
      this.selectedRowKeys = [];
      this.$emit("selectedRow", this.selectedRowKeys);
    },
    onClearSelectedRow() {
      this.selectedRowKeys = [];
    },
    onSearch() {
      this.fetchData();
    },
    refresh() {
      this.search = "";
      this.fetchData();
    },
    onEdit(id) {
      this.$emit("edit", id);
    }
  }
};
</script>
