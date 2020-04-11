<template>
  <div>
    <component :is="errorPage" :error="error" />
  </div>
</template>
<script>
import error404 from "~/components/error/404";
import error401 from "~/components/error/401";
import error500 from "~/components/error/500";

export default {
  layout: "master",
  props: {
    error: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    errorPage() {
      if (this.error.statusCode === 404) {
        return error404;
      } else if (this.error.statusCode === 401) {
        return error401;
      } else {
        return error500;
      }
    }
  }
};
</script>
