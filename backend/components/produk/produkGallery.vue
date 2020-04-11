<template>
  <a-card title="GALERI GAMBAR" class="galery" :bordered="false">
    <a-button type="primary" slot="extra" size="small">
      <a-icon type="plus" />
      Tambah Gambar
    </a-button>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center" :hoverable="false"
      >Content</a-card-grid
    >
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
    <a-card-grid style="width:25%;text-align:center">Content</a-card-grid>
  </a-card>
</template>
<script>
export default {
  data() {
    return {};
  }
};
</script>
