<template>
  <div :style="{ textAlign: 'center' }">
    <div>
      <img
        src="~/assets/image/error_404.jpg"
        alt="error_404"
        :style="{ widht: '600px', height: '400px' }"
      />
    </div>
    <div>
      <h2 :style="{ fontSize: '50px', color: '#748593', marginBottom: '0px' }">
        Oops....
      </h2>
      <p :style="{ fontSize: '30px', lineHeight: '20px' }">
        {{ error.message }}
      </p>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    error: {
      type: Object,
      default: () => {}
    }
  }
};
</script>
