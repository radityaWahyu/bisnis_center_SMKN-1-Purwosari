<template>
  <div class="content container" :style="{ textAlign: 'center' }">
    <div>
      <img
        src="~/assets/image/error_500.png"
        alt="error_500"
        :style="{ widht: '600px', height: '400px' }"
      />
    </div>
    <div>
      <h2 :style="{ fontSize: '50px', color: '#748593', marginBottom: '0px' }">
        Oops....
      </h2>
      <p
        :style="{
          fontSize: '22px',
          lineHeight: '20px',
          color: '#748593',
          fontWeight: '400',
        }"
      >
        <strong>Message :</strong>
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
      default: () => {},
    },
  },
};
</script>
