<template>
  <a-card id="datatable">
    <div slot="title">
      <a-row type="flex" justify="space-between" align="middle">
        <a-col :span="12">
          <a-input-search
            placeholder="Cari user..."
            @search="onSearch"
            v-model="search"
          />
        </a-col>
        <a-col :span="10">
          <a-form-item
            :validate-status="listValidate"
            has-feedback
            :style="{ padding: '0px', marginBottom: '0px' }"
          >
            <a-select
              placeholder="Filter Jurusan"
              :style="{ width: '100%' }"
              @change="onFilter()"
              v-model="filter"
            >
              <a-select-option value="">
                Filter Jurusan
              </a-select-option>
              <a-select-option v-for="row in jurusan" :key="row.id">
                {{ row.departement }}
              </a-select-option>
            </a-select>
          </a-form-item>
        </a-col>
        <a-col :span="1">
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
      size="small"
    >
      <span slot="name" slot-scope="text, record">
        <a-row type="flex" align="middle" :row-gutter="32">
          <a-col>
            <a-avatar
              shape="square"
              size="large"
              :src="
                record.image.length > 0
                  ? getAvatar(record.image)
                  : getAvatar(null)
              "
              :style="{ marginRight: '10px' }"
              class="avatar"
            />
          </a-col>
          <a-col>
            <h2 :style="{ textTransform: 'capitalize', margin: '0px' }">
              {{ record.name }}
            </h2>
            <div
              :style="{
                margin: '0px',
                color: '#8E8F90'
              }"
            >
              Email / Username : <strong>{{ record.email }}</strong>
            </div>
          </a-col>
        </a-row>
      </span>
      <span slot="level" slot-scope="text, record">
        <a-tag
          color="#2db7f5"
          v-if="record.level === 'admin'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.level }}
        </a-tag>
        <a-tag
          color="#108ee9"
          v-if="record.level === 'operator'"
          :style="{ textTransform: 'capitalize' }"
        >
          {{ record.level }}
        </a-tag>
      </span>
      <span slot="action" class="btn-action" slot-scope="text, record">
        <a-tooltip placement="right">
          <template slot="title">
            Edit
          </template>
          <a-dropdown>
            <a-button type="primary">
              <a-icon type="setting" :style="{ fontSize: '16px' }" />
            </a-button>
            <a-menu slot="overlay">
              <a-menu-item key="1">
                <nuxt-link :to="{ name: 'user-id', params: { id: record.id } }">
                  <a-icon type="edit" style="margin-right: 5px;" />
                  Edit
                </nuxt-link>
              </a-menu-item>
              <a-menu-item key="2">
                <nuxt-link
                  :to="{ name: 'user-detail-id', params: { id: record.id } }"
                >
                  <a-icon type="read" style="margin-right: 5px;" />
                  Detail User
                </nuxt-link>
              </a-menu-item>
            </a-menu>
          </a-dropdown>
        </a-tooltip>
      </span>
    </a-table>
  </a-card>
</template>
<script>
import { mapActions } from "vuex";

const columns = [
  {
    title: "User",
    dataIndex: "name",
    sorter: true,
    key: "name",
    scopedSlots: { customRender: "name" }
  },
  {
    title: "Handphone",
    dataIndex: "phone",
    sorter: false,
    key: "phone"
  },
  {
    title: "Jurusan",
    dataIndex: "departement_name",
    sorter: true,
    key: "departement_name"
  },
  {
    title: "Level",
    dataIndex: "level",
    sorter: true,
    key: "level",
    scopedSlots: { customRender: "level" }
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
      search: "",
      columns,
      loadingBest: false,
      listValidate: "",
      selectedRowKeys: [],
      filter: "",
      row: [],
      jurusan: [],
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
    this.getList();
  },
  computed: {},
  methods: {
    ...mapActions("user", ["getUser"]),
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

      if (this.search.length > 0) {
        const search = `search=${this.search}`;
        url = `${url}&${search}`;
      }

      if (this.filter.length > 0) {
        const filter = `filter=${this.filter}`;
        url = `${url}&${filter}`;
      }

      try {
        //  Get data departemen from API
        const { data, meta } = await this.getUser(url);
        this.row = data;
        this.paginate.total = meta.total;
        this.paginate.pageSize = meta.per_page;
        this.paginate.current = meta.current_page;
      } catch (error) {
        console.log(error);
      }
      this.loading = false;
    },
    async getList() {
      try {
        this.listValidate = "validating";
        // get list from departement
        const { data } = await this.$store.dispatch(
          "departement/getListDepartement"
        );
        this.jurusan = data;
        this.listValidate = "";
      } catch (error) {
        console.log(error);
      }
    },
    onFilter() {
      this.fetchData();
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
      this.filter = "";
      this.fetchData();
    }
  }
};
</script>
