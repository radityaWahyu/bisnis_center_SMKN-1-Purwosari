<template>
  <a-breadcrumb :style="{ padding: '10px 0px 10px 24px' }">
    <a-breadcrumb-item
      v-for="item in crumbs"
      :key="item.index"
      :style="{ textTransform: 'capitalize' }"
      >{{ item.text }}</a-breadcrumb-item
    >
  </a-breadcrumb>
</template>
<script>
export default {
  computed: {
    crumbs() {
      const pathArray = this.$route.path.split("/");
      const breadCrumbs = [];
      pathArray.shift();
      //  console.log(this.$route.matched);
      //  console.log(pathArray)
      pathArray.map((path, idx) => {
        const text = path;
        if (this.isEmpty(this.$route.params)) {
          breadCrumbs.push({ path, text });
        } else if (this.$route.matched[idx] !== undefined) {
          breadCrumbs.push({
            path,
            text
          });
        }
      });
      return breadCrumbs;
    }
  },
  methods: {
    isEmpty(myObj) {
      for (const key in myObj) {
        return false;
      }
      return true;
    }
  }
};
</script>
