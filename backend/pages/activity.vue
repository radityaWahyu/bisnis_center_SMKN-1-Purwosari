<template>
  <div>
    <div :style="{ display: 'flex', justifyContent: 'space-between' }">
      <h2 :style="{ fontSize: '22px', fontWeight: '600' }">
        <a-icon type="solution" :style="{ marginRight: '10px' }" />Riwayat User
      </h2>
    </div>
    <div :style="{ display: 'flex' }">
      <a-icon
        type="info-circle"
        :style="{ fontSize: '40px', margin: '10px' }"
        theme="twoTone"
        two-tone-color="#4163E2"
      />
      <div :style="{ verticalAlign: 'top', margin: '10px' }">
        Halaman ini dipergunakan untuk memantau aktifitas operator dan admin
        dalam menggunakan sistem ini.
      </div>
    </div>
    <activity-table />
  </div>
</template>
<script>
export default {
  middleware: "isAdmin",
  layout: "master",
  data() {
    return {
      selectedRow: []
    };
  },
  head() {
    return {
      title: "Riwayat user",
      meta: [
        {
          hid: "description",
          name: "description",
          content: "Riwayat User"
        }
      ]
    };
  },
  components: {
    activityTable: () => import("~/components/activity/activityTable")
  }
};
</script>
